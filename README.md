Advanced Web Development
================

**Best practices Used**

- Custom Informative messages in the form of app flashes for errors, warnings and success messages.

Security Voters to restrict delete and edit functionality 
- https://symfony.com/doc/3.4/best_practices/security.html#using-expressions-for-complex-security-restrictions

DB password environment variables 
   - https://symfony.com/doc/3.4/best_practices/configuration.html


Services - Created for book, review, pagination 

DependancyInjection - For fetching services from container rather than use $this->get()
-   https://symfony.com/doc/3.4/best_practices/controllers.html#fetching-services

Ensured that code conforms to PSR-1 Coding standards using PHP CS Fixer to detect where they dont conform and then fixing that 
-   https://symfony.com/doc/3.4/contributing/code/standards.html
    

Ensure that the folder structure including assets follows recommendations from 
- https://symfony.com/doc/3.4/best_practices/creating-the-project.html#structuring-the-application
 
Overriding execption templates 
- https://symfony.com/doc/3.4/controller/error_pages.html#overriding-the-default-error-templates
 
**Bundles Used**
    
    -   FOSUserBundle For Users
    -   EasyAdminBundle For Admin Of All Entities
    -   VichUploadBundle For Image Upload
    -   KnpPagination For Pagination
    
Enforcing Decopled code
- https://www.tomasvotruba.cz/blog/2017/10/16/how-to-use-repository-with-doctrine-as-service-in-symfony/

Book ISBN Generator
- https://generate.plus/en/number/isbn
