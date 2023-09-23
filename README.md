# Report_Management_System
Document Management System
Document Management System is a web application that allows users to upload, store, view, download, and manage documents efficiently. This system provides a user-friendly interface for managing digital documents in a secure and organized manner.

Features
User Authentication: Users can sign up and log in to access their personalized document management dashboard.

Document Upload: Users can upload documents in various formats (e.g., PDF, Word, Excel) to the system.

Document Viewing: Uploaded documents can be viewed directly in the browser.

Document Download: Users can download their documents for offline use.

Document Deletion: Users can delete documents they no longer need.

Commenting: Users can add comments to documents to provide feedback or collaborate.

Search Functionality: Users can search for documents by name or keywords.

Email Integration: Users can send documents to others via email directly from the system.

Real-Time Collaboration: Collaborate with others in real-time for document editing and annotations.

Getting Started
These instructions will help you set up and run the Document Management System on your local machine for development and testing purposes. For deployment, consider using a production-ready web server and database.

Prerequisites
PHP (>= 7.0)
MySQL or another compatible database system
Apache or another web server

Installation
Clone the repository to your local machine:
git clone https://github.com/yourusername/document-management-system.git
Create a MySQL database and import the provided SQL schema (database.sql) to set up the required database tables.

Configure your database connection by editing the config.php file:
$db_host = 'your_database_host';
$db_username = 'your_database_username';
$db_password = 'your_database_password';
$db_name = 'your_database_name';
Start your web server and navigate to the project's root directory using your web browser.

You should see the login and signup pages. Create an account to access the system.


