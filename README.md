git pull ,
composer install,
npm install,
php artisan migrate --seed



Admin route is same for all users
check sidebar.blade it has if condition for check the role and show navbar links based on user. Curently only for admins. Add suitable nav links for other user roles

routes as middlware groups for each user type



user details
'name' => 'Super Admin',
            'email' => 'superadmin@material.com',
            'password' => ('secret')
            
'name' => 'Admin',
            'email' => 'admin@material.com',
            'password' => ('secret')

'name' => 'Tutor',
            'email' => 'tutor@material.com',
            'password' => ('secret')

'name' => 'Student',
            'email' => 'student@material.com',
            'password' => ('secret')





