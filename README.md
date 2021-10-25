# tenauiCRM25

Author: Uthman Bakar
Role: Software Developer (Tenaui Africa Limited)
Date: 16th September, 2019
Project: Elastic25.com (Tenaui Africa proprietary web application)

Hello, this readme acts as a reminder for me, and as an information resource for developers that may be tasked to maintain, manage and optimize the application. Elastic25 has been operational years before I resumed duty as the brand's software developer, this is my first week and at this point I am just wrapping my head around the innings of the app.

So far, I now understand much of how the app works. A lot of it are not so conventional, but the app works despite some downsides. Most notable points to note so far are:

#ISSUES
--------
I. Database passwords in plain text
II. The DRY rule not followed... repeated html blocks in pages
III. MVC structure not used, application logic embedded in each page

* The url mapping: All pages of the app are mapped in the .htaccess file

This readme will list changes I made to this app after resuming duty. Going fine so far, nothing broken yet and the way I see it, nothing broken here will be beyond fixing. All edits are recorded in git. So let's go, time to turn mediocrity to something awesome.

STAGES/EDITS MADE
-----------------
i. Downloaded the web app source files and databases to work on app locally
ii. Created git repository for local development
iii. Changed database credentials to local values --- File: data\DBConfig.php
iv. Disabled email sending function @ the create service call function for local development purposes ---- File: data/MySQLDatabase.php 354 - 367
