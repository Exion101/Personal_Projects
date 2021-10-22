/* Implementation of Recursive-Descent Parser
 * parse.cpp
*/

#include "parserInt.h"

static int error_count = 0;

map<string, bool> defVar;
map<string, Token> SymTable;
map<string, Value> TempsResults; //Container of temporary locations of Value objects for results of expressions, variables values and constance 
queue <Value> * ValQue; //declare a pointer variable to a queue of Value objects

Token temp_type; // global for type change
string temp_str;

namespace Parser {
	bool pushed_back = false;
	LexItem	pushed_token;

	static LexItem GetNextToken(istream& in, int& line) {
		if( pushed_back ) {
			pushed_back = false;
			return pushed_token;
		}
		return getNextToken(in, line);
	}

	static void PushBackToken(LexItem & t) {
		if( pushed_back ) {
			abort();
		}
		pushed_back = true;
		pushed_token = t;	
	}

}

int ErrCount()
{
    return error_count;
}

void ParseError(int line, string msg)
{
	++error_count;
	cout << line << ": " << msg << endl;
    
}



//Program is: Prog = PROGRAM IDENT {Decl} {Stmt} END PROGRAM IDENT
bool Prog(istream& in, int& line)
{
	bool dl = false, sl = false;
	LexItem tok = Parser::GetNextToken(in, line);
	
	
	if (tok.GetToken() == PROGRAM) {
		tok = Parser::GetNextToken(in, line);
		if (tok.GetToken() == IDENT) {
			dl = Decl(in, line);
			if( !dl  )
			{
				ParseError(line, "Incorrect Declaration in Program");
				return false;
			}
			sl = Stmt(in, line);
			if( !sl  )
			{
				ParseError(line, "Incorrect Statement in program");
				return false;
			}	
			tok = Parser::GetNextToken(in, line);
			
			if (tok.GetToken() == END) {
				tok = Parser::GetNextToken(in, line);
				
				if (tok.GetToken() == PROGRAM) {
					tok = Parser::GetNextToken(in, line);
					
					if (tok.GetToken() == IDENT) {
						return true;
					}
					else
					{
						ParseError(line, "Missing Program Name");
						return false;
					}	
				}
				else
				{
					ParseError(line, "Missing PROGRAM at the End");
					return false;
				}	
			}
			else
			{
				ParseError(line, "Missing END of Program");
				return false;
			}	
		}
	}
	else if(tok.GetToken() == ERR){
		ParseError(line, "Unrecognized Input Pattern");
		cout << "(" << tok.GetLexeme() << ")" << endl;
		return false;
	}
	
	return false;
}

//Decl = Type : VarList 
//Type = INTEGER | REAL | CHAR
bool Decl(istream& in, int& line) {
	bool status = false;
	LexItem tok;
	
	LexItem t = Parser::GetNextToken(in, line);
	
	if(t == INTEGER || t == REAL || t == CHAR) {
		tok = t;
		tok = Parser::GetNextToken(in, line);
		if (tok.GetToken() == COLON) {
			status = IdList(in, line, t);
			//cout<< tok.GetLexeme() << " " << (status? 1: 0) << endl;
			if (status)
			{
				status = Decl(in, line);
				return status;
			}
		}
		else{
			ParseError(line, "Missing Colon");
			return false;
		}
	}
		
	Parser::PushBackToken(t);
	return true;
}

//Stmt is either a PrintStmt, ReadStmt, IfStmt, or an AssigStmt
//Stmt = AssigStmt | IfStmt | PrintStmt | ReadStmt
bool Stmt(istream& in, int& line) {
	bool status;
	
	LexItem t = Parser::GetNextToken(in, line);
	
	switch( t.GetToken() ) {

	case PRINT:
		status = PrintStmt(in, line);
		
		if(status)
			status = Stmt(in, line);
		break;

	case IF:
		status = IfStmt(in, line);
		if(status)
			status = Stmt(in, line);
		break;

	case IDENT:
		Parser::PushBackToken(t);
        status = AssignStmt(in, line);
		if(status)
			status = Stmt(in, line);
		break;
		
	case READ:
		status = ReadStmt(in, line);
		
		if(status)
			status = Stmt(in, line);
		break;

	default:
		Parser::PushBackToken(t);
		return true;
	}

	return status;
}

//PrintStmt:= print, ExpreList 
bool PrintStmt(istream& in, int& line) { 
    LexItem t;
    /*create an empty queue of Value objects.*/
    ValQue = new queue<Value>;
    if( (t=Parser::GetNextToken(in,line)) != COMA){
        ParseError(line,"Missing a Comma");
        return false;
    }

    bool ex=ExprList(in,line);
    
    if(!ex){
        ParseError(line,"Missing expression after print");
        while( !(*ValQue).empty() ){
            ValQue->pop();
        }
        delete ValQue;
        return false;
    }

    //Evaluate: print out the list of expressions' values
    while( !(*ValQue).empty() ){
        Value nextVal=(*ValQue).front();
        cout<<nextVal;ValQue->pop();
    }
    cout<<endl;
    return ex;
}//PrintStmt

//IfStmt:= if (Expr) then {Stmt} END IF
bool IfStmt(istream& in, int& line) {
	bool ex=false ; 
	LexItem t;

	Value retVal;
	
	if( (t=Parser::GetNextToken(in, line)) != LPAREN ) {
		
		ParseError(line, "Missing Left Parenthesis");
		return false;
	}
	
	ex = LogicExpr(in, line, retVal);
	if( !ex ) {
		ParseError(line, "Missing if statement Logic Expression");
		return false;
	}

	if((t=Parser::GetNextToken(in, line)) != RPAREN ) {
		
		ParseError(line, "Missing Right Parenthesis");
		return false;
	}
	
	if((t=Parser::GetNextToken(in, line)) != THEN ) {
		
		ParseError(line, "Missing THEN");
		return false;
	}

	//check if logic expr is true if so then go to stmt
	if(retVal.GetBool() == true){
		bool st = Stmt(in, line);
		if( !st ) {
			ParseError(line, "Missing statement for IF");
			return false;
		}
	}

	if((t=Parser::GetNextToken(in, line)) != END ) {
		
		ParseError(line, "Missing END of IF");
		return false;
	}
	if((t=Parser::GetNextToken(in, line)) != IF ) {
		
		ParseError(line, "Missing IF at End of IF statement");
		return false;
	}
	
	return true;
}

bool ReadStmt(istream& in, int& line)
{
	
	LexItem t;
	
	if( (t=Parser::GetNextToken(in, line)) != COMA ) {
		
		ParseError(line, "Missing a Comma");
		return false;
	}
	
	bool ex = VarList(in, line);
	
	if( !ex ) {
		ParseError(line, "Missing Variable after Read Statement");
		return false;
	}
	return ex;
}
//IdList:= IDENT {,IDENT}
bool IdList(istream& in, int& line, LexItem& type) {
	bool status = false;
	string identstr;    
    if(type.GetToken() == REAL || type.GetToken() == CHAR || type.GetToken() == INTEGER){
		temp_type = type.GetToken();
		// test = type.GetLexeme();
	}
	LexItem tok = Parser::GetNextToken(in, line);
	if(tok == IDENT)
	{
		//set IDENT lexeme to the type tok value
		identstr = tok.GetLexeme();
		if (!(defVar.find(identstr)->second))
		{
			defVar[identstr] = true;
			SymTable[identstr] = temp_type;
		}	
		else
		{
			ParseError(line, "Variable Redefinition");
			return false;
		}
		
	}
	else
	{
		ParseError(line, "Missing Variable");
		return false;
	}
	
	tok = Parser::GetNextToken(in, line);
	
	if (tok == COMA) {
		status = IdList(in, line, tok);
	}
	else if(tok.GetToken() == ERR){
		ParseError(line, "Unrecognized Input Pattern");
		cout << "(" << tok.GetLexeme() << ")" << endl;
		return false;
	}
	else{
		Parser::PushBackToken(tok);
		return true;
	}
	return status;
}

//VarList
bool VarList(istream& in, int& line)
{
	bool status = false;
	string identstr;
	
	LexItem temp;

	status = Var(in, line, temp);
	
	if(!status)
	{
		ParseError(line, "Missing Variable");
		return false;
	}
	
	LexItem tok = Parser::GetNextToken(in, line);
	
	if (tok == COMA) {
		status = VarList(in, line);
	}
	else if(tok.GetToken() == ERR){
		ParseError(line, "Unrecognized Input Pattern");
		cout << "(" << tok.GetLexeme() << ")" << endl;
		return false;
	}
	else{
		Parser::PushBackToken(tok);
		return true;
	}
	return status;
}

//Var:= ident
bool Var(istream& in, int& line, LexItem& tok)
{
	//called only from the AssignStmt function
	string identstr;
	
	// took away LexItem due to parameter, might need two separate lexitem objects
	tok = Parser::GetNextToken(in, line);
	
	if (tok == IDENT){
		identstr = tok.GetLexeme();
		if (!(defVar.find(identstr)->second))
		{
			ParseError(line, "Undeclared Variable");
			return false;
			
		}	
		return true;
	}
	else if(tok.GetToken() == ERR){
		ParseError(line, "Unrecognized Input Pattern");
		cout << "(" << tok.GetLexeme() << ")" << endl;
		return false;
	}
	return false;
}

//AssignStmt:= Var = Expr
bool AssignStmt(istream& in, int& line) {
	
	bool varstatus = false, status = false;
	LexItem t;
	Value retVal;

	varstatus = Var( in, line, t);
	
	temp_str = t.GetLexeme();

	if (varstatus){
		t = Parser::GetNextToken(in, line);
		
		if (t == ASSOP){
			status = Expr(in, line, retVal);
			if(!status) {
				ParseError(line, "Missing Expression in Assignment Statment");
				return status;
			}
			ValQue->push(retVal);
		}
		else if(t.GetToken() == ERR){
			ParseError(line, "Unrecognized Input Pattern");
			cout << "(" << t.GetLexeme() << ")" << endl;
			return false;
		}
		else {
			ParseError(line, "Missing Assignment Operator =");
			return false;
		}
	}
	else {
		ParseError(line, "Missing Left-Hand Side Variable in Assignment statement");
		return false;
	}
	return status;	
}

//ExprList:= Expr {,Expr}
bool ExprList(istream& in, int& line) {
	bool status = false;

	Value retVal;
	status = Expr(in, line, retVal);
	TempsResults[temp_str] = retVal;

	if(!status){
		ParseError(line, "Missing Expression");
		return false;
	}
	
	LexItem tok = Parser::GetNextToken(in, line);
	
	if (tok == COMA) {
		status = ExprList(in, line);
	}
	else if(tok.GetToken() == ERR){
		ParseError(line, "Unrecognized Input Pattern");
		cout << "(" << tok.GetLexeme() << ")" << endl;
		return false;
	}
	else{
		Parser::PushBackToken(tok);
		return true;
	}
	return status;
}

//Expr:= Term {(+|-) Term}
bool Expr(istream& in, int& line, Value& retVal) {
	Value val1, val2;
	bool t1 = Term(in, line, val1);
	LexItem tok;
	
	//cout<<"in Expr"<<endl;
	if( !t1 ) {
		return false;
	}
	retVal = val1;

	tok = Parser::GetNextToken(in, line);
	if(tok.GetToken() == ERR){
		ParseError(line, "Unrecognized Input Pattern");
		cout << "(" << tok.GetLexeme() << ")" << endl;
		return false;
	}
	while ( tok == PLUS || tok == MINUS ) 
	{
		t1 = Term(in, line, val2);
		if( !t1 ) 
		{
			ParseError(line, "Missing operand after operator");
			return false;
		}
		// evaluate the expression for addition or subtraction
		// and update the retVal pbject
		// check if the operation of PLUS/MINUS is legal for the type of operands
		if(retVal.GetType() == VCHAR || val2.GetType() == VCHAR){
			ParseError(line, "Run-Time Error-Illegal Mixed Type Operands");
			return false;
		}
		else{
			if(tok == PLUS){
				retVal = retVal + val2;
			}
			else if(tok == MINUS){
				retVal = retVal - val2;
			}
		}
		tok = Parser::GetNextToken(in, line);
		if(tok.GetToken() == ERR){
			ParseError(line, "Unrecognized Input Pattern");
			cout << "(" << tok.GetLexeme() << ")" << endl;
			return false;
		}		
	}
	Parser::PushBackToken(tok);
	return true;
}

//Term:= SFactor {(*|/) SFactor}
bool Term(istream& in, int& line, Value& retVal) {
	Value val1,val2;
	bool t1 = SFactor(in, line, retVal);
	LexItem tok;
		
	if( !t1 ) {
		return false;
	}
	retVal = val1;

	tok	= Parser::GetNextToken(in, line);
	if(tok.GetToken() == ERR){
			ParseError(line, "Unrecognized Input Pattern");
			cout << "(" << tok.GetLexeme() << ")" << endl;
			return false;
	}
	while ( tok == MULT || tok == DIV  )
	{
		t1 = SFactor(in, line, retVal);
		
		if( !t1 ) {
			ParseError(line, "Missing operand after operator");
			return false;
		}
		// evaluate the expression for addition or subtraction
		// and update the retVal pbject
		// check if the operation of PLUS/MINUS is legal for the type of operands
		if(retVal.GetType() == VCHAR || val2.GetType() == VCHAR){
			ParseError(line, "Run-Time Error-Illegal Mixed Type Operands");
			return false;
		}
		// check for illegal 0 division
		if(val2.GetInt() == 0){
			ParseError(line, "Run-Time Error-Illegal Division by Zero");
		}
		else{
			if(tok == MULT){
				retVal = retVal * val2;
			}
			else if(tok == DIV){
				retVal = retVal / val2;
			}
		}		
		tok	= Parser::GetNextToken(in, line);
		if(tok.GetToken() == ERR){
			ParseError(line, "Unrecognized Input Pattern");
			cout << "(" << tok.GetLexeme() << ")" << endl;
			return false;
		}
		
	}
	Parser::PushBackToken(tok);
	return true;
}

//SFactor = Sign Factor | Factor
bool SFactor(istream& in, int& line, Value& retVal)
{
	LexItem t = Parser::GetNextToken(in, line);
	bool status;
	int sign = 0;

	if(t == MINUS )
	{
		sign = -1;
	}
	else if(t == PLUS)
	{
		sign = 1;
	}
	else
		Parser::PushBackToken(t);
		
	status = Factor(in, line, sign, retVal);
	return status;
}
//LogicExpr = Expr (== | <) Expr
bool LogicExpr(istream& in, int& line, Value& retVal)
{
	Value val1, val2;
	bool t1 = Expr(in, line, val1);
	LexItem tok;
	
	if( !t1 ) {
		return false;
	}
	retVal = val1;
	
	tok = Parser::GetNextToken(in, line);
	if(tok.GetToken() == ERR){
		ParseError(line, "Unrecognized Input Pattern");
		cout << "(" << tok.GetLexeme() << ")" << endl;
		return false;
	}
	if ( tok == LTHAN  || tok == EQUAL) 
	{
		t1 = Expr(in, line, val2);
		if( !t1 ) 
		{
			ParseError(line, "Missing expression after relational operator");
			return false;
		}
		// evaluate the expression for addition or subtraction
		// and update the retVal pbject
		// check if the operation of PLUS/MINUS is legal for the type of operands
		if(retVal.GetType() == VCHAR || val2.GetType() == VCHAR){
			ParseError(line, "Run-Time Error-Illegal Mixed Type Operands");
			return false;
		}
		else{
			if(tok == LTHAN){
				retVal = (val1 < val2);
				return true;
			}
			else if(tok == EQUAL){
				retVal = (val1 = val2);
				return true;
			}
		}
		return false;
	}
	Parser::PushBackToken(tok);
	return true;
}

//Factor := ident | iconst | rconst | sconst | (Expr)
bool Factor(istream& in, int& line, int sign, Value& retVal) {
	
	LexItem tok = Parser::GetNextToken(in, line);
	if( tok == IDENT ) {
		//check if the var is defined 
		string lexeme = tok.GetLexeme();
		if (!(defVar.find(lexeme)->second))
		{
			ParseError(line, "Undefined Variable");
			return false;	
		}
		return true;
	}
	else if( tok == ICONST ) {
		retVal.SetType(VINT);
		int temp = stoi(tok.GetLexeme());
		if(sign != 0){
			temp = temp * sign;
		}

		retVal.SetInt(temp);
		return true;
	}
	else if( tok == SCONST ) {
		retVal.SetType(VCHAR);
		retVal.SetChar(tok.GetLexeme());

		return true;
	}
	else if( tok == RCONST ) {
		retVal.SetType(VREAL);
		float temp = stof(tok.GetLexeme());
		if(sign != 0){
			temp = temp * sign;
		}
		retVal.SetReal(temp);
		return true;
	}
	else if( tok == LPAREN ) {
		bool ex = Expr(in, line, retVal);

		if( !ex ) {
			ParseError(line, "Missing expression after (");
			return false;
		}
		if( Parser::GetNextToken(in, line) == RPAREN )
			return ex;

		ParseError(line, "Missing ) after expression");
		return false;
	}
	else if(tok.GetToken() == ERR){
		ParseError(line, "Unrecognized Input Pattern");
		cout << "(" << tok.GetLexeme() << ")" << endl;
		return false;
	}

	ParseError(line, "Unrecognized input");
	return 0;
}


