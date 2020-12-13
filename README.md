# HackOffV3---Team-DrainBrain
Repository containing all the code for problem statement 3 in Siemens Healthcare challenge at HackOffV3.

* We would like to thank the wonderful people at deepset for creating amazing apis like Haystack and we have used their api for creating this project.
* The problem statement was to develop a chatbot for initial medical screening and we have developed a chatnot using a revolutionary technology called Neural Search.
* Advantages of using the type of technology that we used to make our chatbot:
1) You can use state-of-the-art models like BERT,RoBERTa for both extractive qa and generative qa.
2) You can use powerful information retrieval systems like Elasticsearch and Faiss.
3) Scalable to millions of documents in the database.
4) The main advantage is that these type of chatbots can even learn about the patients generate answers and will be able to give precision medicine to every patient.
5) We can also finetune the pretrained model for our specific usecase.

## Technology used:

![Screenshot (279)](https://user-images.githubusercontent.com/55051841/102008336-a08c5d00-3d55-11eb-9378-71de661ddae6.png)

1) FileConverter: Extracts pure text from files (pdf, docx, pptx, html and many more).
2) PreProcessor: Cleans and splits texts into smaller chunks.
3) DocumentStore: Database storing the documents, metadata and vectors for our search. We have used facebook's FAISS for information retrieval and it can do dense passage retrieval using dual auto-encoders. Basically it will search semantically and give the relevant documents.
4) Retriever: Fast algorithms that identify candidate documents for a given query from a large collection of documents. Retrievers narrow down the search space significantly and are therefore key for scalable QA. We have used a Retreiver build upon FAISS.
5) Reader: Neural network (e.g. BERT or RoBERTA) that reads through texts in detail to find an answer. The Reader takes multiple passages of text as input and returns top-n answers. We have used the RoBERTa base model pretrained on the Stanford Squad dataset as our reader.
6) Finder: Glues together a Retriever + Reader/Generator as a pipeline to provide an easy-to-use question answering interface.
7) Generator: Neural network (e.g. RAG) that generates an answer for a given question conditioned on the retrieved documents from the retriever. We did not use any generator for our project.

## Data:
1) We have scraped a lot of data regarding diseases, medicine, common healthcare related data from many websites like WebMD, Mayoclinic etc.

## Sample Results:

![Screenshot (281)](https://user-images.githubusercontent.com/55051841/102008457-9e76ce00-3d56-11eb-843a-a96e84cf8e12.png)

![Screenshot (282)](https://user-images.githubusercontent.com/55051841/102008464-b51d2500-3d56-11eb-9924-08c12923651e.png)

![Screenshot (283)](https://user-images.githubusercontent.com/55051841/102008470-c2d2aa80-3d56-11eb-96c9-64ac762e38dd.png)


## Video demo: https://drive.google.com/drive/folders/1JLd9thBOQTG50B1iwzj5_3a9LkTXkySr?usp=sharing

## Instructions to run the chatbot and see the results for yourself:
1) Download Xampp
2) Go to htdocs folder
3) Download the 'hackoff' folder from https://drive.google.com/drive/folders/1dXPzR36g1BPcyhigl5GKqnNsVXgxWpKz?usp=sharing
4) Copy and paste the 'hackoff' folder in htdocs
5) Open the final deployment notebook in colab and click on run all and wait till all the cells got executed except the last cell which will keep running. Basically this cell act like our backend.
6) now open the website in localhost by typing in 'localhost/hackoff' and type the username as 'user1' and password as 'sample'.
7) You are good to go. Type in any medical related question and viola, you will get an answer.
