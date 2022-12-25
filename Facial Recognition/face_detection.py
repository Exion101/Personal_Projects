import face_recognition
import pickle
import cv2
import os
 
# cascade holds what we need to do the facial detector
cascPathface = os.path.dirname(cv2.__file__) + "/data/haarcascade_frontalface_alt2.xml"
faceCascade = cv2.CascadeClassifier(cascPathface)

# use the encoded images
data = pickle.loads(open('face_enc', "rb").read())
 
print("Video Started")
video_capture = cv2.VideoCapture(0)

while True:
    # grab the frame and manipulate the image to work for us
    ret, frame = video_capture.read()
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    faces = faceCascade.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=5, minSize=(60, 60), flags=cv2.CASCADE_SCALE_IMAGE)
 
    # convert the input frame from BGR to RGB 
    rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)

    # encode the video frame 
    encodings = face_recognition.face_encodings(rgb)
    names = []
    
    # compare the encodings to that of the videos
    for encoding in encodings:

        matches = face_recognition.compare_faces(data["encodings"], encoding)
        name = "Unknown"

        # check if match found
        if True in matches:
            #Find positions at which we get True and store them
            matchedIdxs = [i for (i, b) in enumerate(matches) if b]
            counts = {}

            for i in matchedIdxs:
                #Check the names at respective indexes we stored in matchedIdxs
                name = data["names"][i]
                #increase count for the name we got
                counts[name] = counts.get(name, 0) + 1

            # name is the one with most matches to increase accuracy
            name = max(counts, key=counts.get)
 
        # update the list of names
        names.append(name)

        # draw the boxes onto the image
        for ((x, y, w, h), name) in zip(faces, names):
            if name == "Unknown":
                 cv2.rectangle(frame, (x, y), (x + w, y + h), (0, 0, 255), 2)
                 cv2.putText(frame, name , (x, y), cv2.FONT_HERSHEY_SIMPLEX,
                0.75, (0, 0, 255), 2)
            else:
                cv2.rectangle(frame, (x, y), (x + w, y + h), (0, 255, 0), 2)
                cv2.putText(frame, name , (x, y), cv2.FONT_HERSHEY_SIMPLEX,
                0.75, (0, 255, 0), 2)

    cv2.imshow("Frame", frame)
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break
video_capture.release()
cv2.destroyAllWindows()