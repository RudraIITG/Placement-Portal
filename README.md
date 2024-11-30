# This Project is made under the supervision of Prof. Ashok Singh Sairam, IIT Guwahati. The project is titled Placement-Portal and is a proficient web application having all features needed in a recruitment process starting from student registration to shortlisting students based on cut off criteria. I was accompanied by Kunal in this project.

We have used HTML and CSS for front end development and used PHP for backend applications and connecting to the database, we stored the data in Xampp(phpmyAdmin Database) and used MySQL for database creation and table query.
The project has the following major features:
1. Student/ Recruiter registration and account formation
2. Job offering and Job application
3. Shortlisting tests
4. Candidate selection by Recruiter


For this project we are using our database named PlacementData which has the following associated tables:

1. Student_login
This table stores student login information.
•	RollNo – Integer type and primary key
•	Name – varchar (30)
•	Password – Varchar (255)  and stored in a hashed format

2. Company_login
This table stored company login information
•	CompanyId – Integer Primary key
•	Company Name – Varchar (30)
•	Password – Varchar (255) and stored in a hashed format

3. Students
This table stores the student academic and personal details
•	Roll – Integer Primary key 
•	Name – Varchar (30)
•	CPI – Double
•	Backlogs – Enum (yes / no)
•	Branch – Varchar (20)
•	Degree – Varchar (10)
•	Department – Varchar (20)

4. Jobs
This table stores details of the job offered by various companies
•	JobID – Integer 
•	CompanyId – Integer (foreign key referring Company_login) 
•	CompanyName – Varchar (30)
•	JobDescription – Varchar(100)
•	Salary – Integer
•	MinCPI – Double
•	Backlog Allowed – enum(yes/no)
In this table (JobId, CompanyId )is the primary key

5. Apply
This table is the relation table between students and jobs.
•	Roll – Integer
•	JobID- Integer
•	CompanyID – Integer
•	CompanyName – Varchar(20)
In this table (Roll, JobID, CompanyID) is the primary key.
Roll, JobID and CompanyID are foreign keys referring to the Students, Jobs and Company_login respectively.

6. Test
This table has information of tests that have been scheduled
•	JobId – Integer
•	CompanyId – Integer
•	Type – Enum (aptitude / Interview)
•	Date 
•	Mode – Enum(online/offline)
•	Duration- Integer
In this table (JobId, CompanyId) is the primary key.
JobId , CompanyId are foreign keys referring to Jobs and Company_login respectively.

7. Test_Performance
This table contains scores of students in tests for particular jobs
•	JobId – Integer
•	CompanyId – Integer
•	RollNo – Integer
•	Score – Integer
•	Type – enum(aptitude / interview)
In this table (JobId, CompanyId, RollNo, Type) is primary key.
JobId, CompanyId, RollNo are foreign key referring to jobs,Company_login, students respectively.

8. Shortlists
Stores details of shortlisted candidate
•	RollNo – Integer
•	CompanyId – Integer
•	JobId – Integer
In this table (RollNo, Companyid, JobId) is primary key.
Foreign key referring is same as the previous.


9. Selections
Stores details of selected candidate
•	RollNo – Integer
•	CompanyId – Integer
•	JobId – Integer
In this table (RollNo, Companyid, JobId) is primary key.
Foreign key referring is same as the previous.
