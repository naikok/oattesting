# oat

Requirements:

For this project I have decided to use symfony 5 framework

Installation:

    Clone the project from github and install all dependencies needed to get this working.
    In order to install the dependencies, just go to the root folder of the project and make composer install

How to make this working:

    Go to the main project folder and run the server by using this command line: php bin/console server:start *:8080

API:

There are 2 main endpoints that are called under questions path:
    
    - In order to get all questions by providing the language you should go to this url or calling by GEY (Example in spanish)
      http://127.0.0.1:8080/questions?lang=es
      
    
    - In order to save a new questions with its choices we should call to the API as POST request.
      http://127.0.0.1:8080/questions
      
      Example json needed to send in request as content
      
      {"Question":{"Question text":"How are you doing?","choices":["fine","very good","too bad"]}}
        
        
Solution problems:

    In order to change the datasource to be managed, go to the ManagerDataService.php class implemented as Adapter Pattern Design and change the variable $dataSource into json or csv

    Solution can be improved much more, by covering with unit testing and integration tests.
    
    Some methods such as save questions into json file was not implemented due to lack of time, method save should be implemented for saving questions into json file

    As improvement of work, TranslatorService can be implemented with an Interface, these methods must be accomplished as mandatory contract in any translator service new included, just in case of change to another translatorService for future. This issue gives more flexibiliy. Right now this is not implemented yet