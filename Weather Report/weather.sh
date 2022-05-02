#!/bin/bash

# array of cities
cities=("https://forecast.weather.gov/MapClick.php?CityName=Edgewater&state=NJ&site=OKX&textField1=40.8214&textField2=-73.9784&e=1#.Yl9443XMKV4" "https://forecast.weather.gov/MapClick.php?CityName=Hoboken&state=NJ&site=OKX&textField1=40.7426&textField2=-74.0288&e=0#.Yl96lHXMJhE
" "https://forecast.weather.gov/MapClick.php?CityName=Jersey+City&state=NJ&site=OKX&textField1=40.7113&textField2=-74.065#.Yl97KHXMJhE
" "https://forecast.weather.gov/MapClick.php?CityName=Trenton&state=NJ&site=PHI&textField1=40.2234&textField2=-74.7642&e=1#.Yl97anXMJhE
" "https://forecast.weather.gov/MapClick.php?CityName=West+New+York&state=NJ&site=OKX&textField1=40.7859&textField2=-74.0098&e=0#.Yl97l3XMJhE"
)

fileNames=("Edgewater.html" "Hoboken.html" "JC.html" "Trenton.html" "WNY.html")
#downloads webpage into associated filename 
while true; do
    for i in ${!cities[*]}
    do
        echo `wget "${cities[$i]}" -O ${fileNames[$i]}`
    done

    # Download tagsoup if it does not exist in current DIR
    FILE=./tagsoup-1.2.1.jar
    if test -f "$FILE"
    then
        echo "$FILE exists"
    else
        echo `wget https://repo1.maven.org/maven2/org/ccil/cowan/tagsoup/tagsoup/1.2.1/tagsoup-1.2.1.jar`
    fi


    # use tagsoup to create xhtml from html
    for file in ${fileNames[@]}
    do  
        if test -f "$file"
        then
        # if html file exists then pass through tagsoup
            echo `java -jar tagsoup-1.2.1.jar --files ${file}`
        fi
    done

    # call parser.py with xhtml passed as arg
    xhtmlFileNames=("Edgewater.xhtml" "Hoboken.xhtml" "JC.xhtml" "Trenton.xhtml" "WNY.xhtml")
    for file in ${xhtmlFileNames[@]}
    do
        if test -f "$file"
        then
        # Execute parser.py
            echo `python3 parser.py ${file}` 
        else   
            echo "$file does not exist"
        fi
    done


    # erase html xhtml
    for file in ${xhtmlFileNames[@]}
    do  
        if test -f "$file"
        then
        # remove file
            echo `rm $file`
        fi
    done
    for file in ${fileNames[@]}
    do
        if test -f "$file"
        then
        # remove file
            echo `rm $file`
        fi
    done

    echo "use index.php to start"
    echo "going to sleep for 6hrs"
    sleep 6h # sleep every six hours
    echo "good nap i wake up and work now..."
done