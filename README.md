## Kethod Admin Panel
This repository is a boilerplate for the Laravel Admin Panel.
---
Currently its supporting following themes.
1. Default Laravel Theme
2. SB Admin
3. Vali Bootstrap

Default login credentials.
email : admin@gmail.com
pass  : password

You can change theme of admin panel from Settings screen.

Structure of Controller File
---
Basic controller file contain following methods. 
1. index 
2. create 
3. edit
4. store
5. update
6. ajax // This screen actually loads data from database and put in index.blade.php 
7. delete

In order to create new CRUD operation, you can simply copy existing controller file and change {$handle_name} name. It will allow you to create new CRUD operations faster than before.

Structure of Blade Files
---
1. table_name/index.blade.php // Base View
2. table_name/ajax.blade.php // For Retriving data
3. table_name/manage.blade.php // For Insert/Edit

e.g. for users table it will be as following.
1. users/index.blade.php
2. users/ajax.blade.php
3. users/manage.blade.php

You can easily clone CRUD operation.
structure of Controller File & Blade files are standard. So you can just copy controller and blade files to create new CRUD operation.

Two Factor Authentication
--
1. This admin panel support TFA by Email.
2. By default two factor authentication is disabled.
3. Once you are logged in. you can go to settings-> edit profile and turn on two factor authentication for you.

*Advance Two Factor Authentication*
If you wanted to advance your two factor authentication. 
1. Modify middleware "twofactor" with your logic.
2. Modify Http/Controllers/Auth/LoginController -> authenticated() method with your logic.
3. Two Factor code generation is happening inside User's Model. (Modify if needed)
4. Redirection to Two Factor Screen is happening inside TwoFactorController (Modify if needed)

*Example of new CRUD Operation*
Now, consider that I wanted to create new crud operation for categories. Here are the steps you need to follow.
1. Create model & migration file.
2. Make sure your model uses Softdelete
3. Clone Users/Role Controller and Change handler to 'category'
5. Once you clone controller. make sure your update model name in controller file.
6. Clone directory 'view/themes/your_selected_theme/roles' and name it 'categories' (same as your database table name).
7. Clone roles routes from web.php and change roles to categories & update RoleController to CategoryController.
8. Once you are done with all changes, make sure your blade file (specific ajax.blade file is having fields that you have defined in migration)


![1](https://user-images.githubusercontent.com/13075784/115128421-451bf580-9ffb-11eb-896e-594cf3e901a2.png)
![2](https://user-images.githubusercontent.com/13075784/115128423-464d2280-9ffb-11eb-907a-33cc7553a9b4.png)
![3](https://user-images.githubusercontent.com/13075784/115128424-46e5b900-9ffb-11eb-83f8-9aa3e023b03a.png)
![4](https://user-images.githubusercontent.com/13075784/115128425-46e5b900-9ffb-11eb-9217-43aefa3c463b.png)
![5](https://user-images.githubusercontent.com/13075784/115128426-477e4f80-9ffb-11eb-97d9-b4f58e21027d.png)


