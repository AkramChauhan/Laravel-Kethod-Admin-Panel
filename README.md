## Kethod Admin Panel
This repository is a boilerplate for the Laravel Admin Panel.
---
Currently its supporting following themes.
1. Default Laravel Theme
2. SB Admin
3. Vali Bootstrap

In order to change theme, simply change APP_THEME constant from .ENV file.
#APP_THEME="default"
#APP_THEME="sb-admin"
APP_THEME="vali-bootstrap"

Structure of Controller File
---
Basic controller file contain following methods. 
1. index
2. create
3. edit
4. store
5. update
6. ajax
7. delete

In order to create new CRUD operation, you can simply copy existing controller file and change {$handle_name} name. It will allow you to create new CRUD operations faster than before.

Structure of Blade Files
---
table_name/index.blade.php // Base View
table_name/ajax.blade.php // For Retriving data
table_name/manage.blade.php // For Insert/Edit

e.g. for users table it will be as following.
users/index.blade.php
users/ajax.blade.php
users/manage.blade.php

You can easily clone CRUD operation.
structure of Controller File & Blade files are standard. So you can just copy controller and blade files to create new CRUD operation.

![image](https://user-images.githubusercontent.com/13075784/111896842-509eef80-8a42-11eb-9495-d41e982a56bb.png)
![image](https://user-images.githubusercontent.com/13075784/111896846-5694d080-8a42-11eb-93bb-e795ed530314.png)
![image](https://user-images.githubusercontent.com/13075784/111896848-5c8ab180-8a42-11eb-827c-671a407edca6.png)
![image](https://user-images.githubusercontent.com/13075784/111896853-614f6580-8a42-11eb-8e5b-aa880c4cc117.png)

