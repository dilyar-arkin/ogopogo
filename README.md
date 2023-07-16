### Project Highlights

The project incorporates HTML, CSS, and JavaScript for the front-end, while PHP for the backend. The database relies on phpMysql, and version control is managed through Github. During the development phase, incremental updates were pushed to the main branch. However, when designing the poll module (slightly complicated), a separate branch was created for development purposes, which was later merged back upon completion. Additionally, dynamic functionalities were implemented using jQuery and AJAX, while Bootstrap was employed for styling purposes. Using Bootstrap also made it easy for us to implement small device views compatibility.

Our website classifies users into three categories: site visitors, registered users, and administrators. Site visitors have limited privileges and can only access the index page, where they can view the titles of open posts. They can click on any post to view its poll content, including the topic, options, and comments made by others. However, site visitors are not allowed to leave comments or vote. If a site visitor attempts to do so by clicking the vote button or manipulating jQuery hide() elements, the corresponding PHP file that receives the HTTPS request will verify user registration by checking the session start. Unregistered users will be prohibited from leaving comments and participating in votes on the server side. The index page of our website incorporates multiple jQuery functionalities. Users can seamlessly browse popular posts without having to reload the page. The index page displays both closed and open polls, achieved through an AJAX request to a PHP file that separates the polls based on their closing dates and inserts them into the corresponding elements as inner attributes.

Site visitors have the option to either login or register to gain access to the website's core functionalities. When a user registers, their information is stored in the database table, and they can subsequently log in using their username and password. The activities of logged-in users are tracked using PHP sessions. Registered users can view poll results and add comments. Both casted votes and comments are stored in their respective database tables. The voting results and comments are dynamically displayed using PHP files that continuously query data from the database.

The functionality of leaving comments and voting for polls is implemented through JavaScript files using the AJAX method, enabling users to perform these actions without the need for page reloads or redirection to other paths. In addition, logged-in users have the ability to reset their passwords. This process involves updating the relevant database entry through an appropriate SQL query. For security purposes, when a password is changed, the user's session log is destroyed, requiring them to log in again.

Administrators have additional privileges compared to other user categories. Upon logging in, a PHP file responsible for loading contents onto the main page adds extra html lines that make two additional pages visible. From these pages, administrators can delete posts and users. The PHP pages containing the SQL commands for deletion are accessible only to administrators. This access is verified through the session. Users who do not have admin status in the database are restricted from accessing these pages.

In order to enhance security, we have implemented if/else statements to validate the correctness of request methods. For example, if a specific method, such as POST, is expected but a GET method is received, the PHP file will deny access to the inner codes, preventing unauthorized retrieval of information from the database. This additional measure ensures that only the appropriate request methods are allowed, minimizing the risk of unauthorized access. 

If time permits, we acknowledge the significance of implementing additional security features to enhance the overall security of the website. Specifically, we recognize the importance of incorporating regular expressions for validating input on both the client and server sides, as well as implementing string sanitization techniques on the PHP side. These measures would provide further protection against potential vulnerabilities and improve the robustness of the security functionalities. We encountered issues with special characters in poll options and comments, causing disruptions in SQL queries within certain PHP files. Despite efforts, not all bugs were resolved within the project timeline. Further investigation and resolution are needed to enhance system stability.

## Remarks
Despite successfully achieving the primary objectives of the project, some limitations were encountered. Specifically, challenges remained in addressing issues related to inputting special characters. Additionally, the project did not fully implement certain JavaScript functionalities such as form content validation, password checking, and real-time updates of page states. Although efforts were made to incorporate features like updating closing dates in real-time, the implementation of adding comments to the page without reloading in real-time was not completed within the project's timeline. These aspects represent potential areas for future development and improvement going forward. Overall, the project provided valuable insights and learning opportunities in web development, highlighting the significance of robust bug testing and security measures.


## Project proposal

 Ogopogo is a dedicated website catering to residents of the Okanagan Valley, offering a unique platform for individuals to participate in polls and voice their opinions. As one of Canada's fastest growing communities, the Okanagan Valley faces various pressing challenges, including housing and cost of living concerns. Ogopogo provides a space where these issues can be openly discussed, debated, and voted upon by community members. By fostering open dialogue and debate, Ogopogo empowers residents to collectively address critical issues that can impact all of us in the Okanagan Valley.
 
 While bearing some resemblance to Castanet, this website has a distinct focus on providing a platform exclusively for individuals to create forums, participate in polls, and engage in lively discussions. Following the voting process, an interactive comment section will be available, allowing people to delve deeper into the poll results and actively engage in debates and discussions.
 
 The website showcases a modern and minimal user interface, elevating the visual experience for users. The poll results are presented using cutting-edge CSS styling, incorporating sleek and contemporary charts. This innovative approach enhances the presentation of data, making it visually appealing and easily understandable for users.
 
 The security of the website is of utmost importance, and comprehensive measures will be implemented to safeguard against malicious attacks and SQL injections. Robust security protocols will be put in place to ensure the website's resilience and protection of user data. By adopting industry best practices and employing advanced security technologies, we will create a secure environment that minimizes vulnerabilities and mitigates the risks associated with cyber threats, ensuring a safe and trustworthy platform for users.
 

### Our team member 
Dilyar Arkin

### Requirement List

* The main page features a header with navigation links for the register page, account page, and main page (logo).
* The body of the main page displays a list of posted content titles, similar to Hacker.net.
* Site visitors can view the main page and browse through the list of discussions posted on the website.
* By clicking on any published discussion, the site visitor will be redirected to the respective discussion page.
* If a poll is not closed, site visitors are unable to view the poll status but can still view comments.
* Site visitors cannot participate in polls or leave comments. The user interface recommends registration if they attempt to do so.
* Each post is required to have a poll, ensuring that the topic is debatable.
* Polls have an opening time limit, and once the time is over, the poll is closed and becomes view-only.
* When creating a post, the user enters the topic and a list of options. JavaScript dynamically renders the chart for the poll.
* Registered users can view the current status of a poll when they open a post. After casting a vote, the result is updated asynchronously.
* The system keeps track of the number of comments and posts created by users, and users are ranked based on these two attributes.
* Security implementations: To be added and detailed later in the development process.

There are 3 main actors in this site. 
   - Admin: The admin has complete access to both the front and back end of the website. They possess the authority to make modifications across all layers of the system, enabling them to manage and control the website's functionality and content effectively.
   - Registered User: Registered users have full access to the dynamic interactions on the client side. They can actively participate in polls by casting their votes and contribute to discussions by leaving comments. Registered users enjoy a comprehensive engagement experience on the website.
   - Visitor: Visitors, although not registered users, can still partially interact with the client side features. They can view the titles of discussions, read comments, and access the results of closed polls. However, they do not have the ability to actively participate in polls or leave comments themselves.

**For the web development stack, we have chosen to utilize a Dockerized environment consisting of Windows, Apache, MySQL, and PHP. This stack provides a robust and efficient foundation for developing the website. Once all the functions have been thoroughly tested and validated, the website will be integrated into the cosc360.ok.ubc.ca server.**

**Additionally, we are considering implementing Continuous Integration and Continuous Deployment (CI/CD) using GitHub. This approach will streamline the development process by automating the build, testing, and deployment stages. By leveraging CI/CD, we aim to ensure a smooth and efficient workflow for future updates and enhancements to the website.**

