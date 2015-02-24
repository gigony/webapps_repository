Introduction
=============

This is a web application repository for an experiment.
The followings are instructions for application installation and setup.


Install Apache, PHP, Mysql
=============================

Install APM
-----------

Reference : https://medium.com/@raureif/os-x-yosemite-how-to-set-up-apache-mysql-and-php-with-homebrew-4bc236d7d9fa

1. Install Xcode Command Line Tools
  - `$ xcode-select --install` or [link](https://developer.apple.com/downloads/index.action?=command%20line%20tools#)
2. Install HomeBrew
  - `$ ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"`
3. Install dnsmasq
  - `$ brew install dnsmasq`
  - `$ cd $(brew --prefix)`
  - `$ mkdir etc`
  - `$ echo 'address=/.dev/127.0.0.1' > etc/dnsmasq.conf`
  - `$ sudo cp -v $(brew --prefix dnsmasq)/homebrew.mxcl.dnsmasq.plist /Library/LaunchDaemons`
  - `$ sudo launchctl load -w /Library/LaunchDaemons/homebrew.mxcl.dnsmasq.plist`
  - `$ sudo mkdir /etc/resolver`
  - `$ sudo bash -c 'echo "nameserver 127.0.0.1" > /etc/resolver/dev'`
4. httpd.conf
  - Edit /private/etc/apache2/httpd.conf
    - Uncomment some lines
      - line 160 
        - `LoadModule vhost_alias_module libexec/apache2/mod_vhost_alias.so`
      - line 168
        - `LoadModule rewrite_module libexec/apache2/mod_rewrite.so`
      - line 169
        - `LoadModule php5_module    /usr/local/opt/php55/libexec/apache2/libphp5.so`
        - not `LoadModule php5_module libexec/apache2/libphp5.so` (we use homebrew-based php55 because of libpng and mcrypt module),
      - line 499
        - `Include /private/etc/apache2/extra/httpd-vhosts.conf`
    - Add “index.php” in line 271
           <IfModule dir_module>
              DirectoryIndex index.html index.php
           </IfModule>
5. Install Homebrew-based php55
  - installed brew-based php5.5 because of libpng and mcrypt module
    - http://stackoverflow.com/questions/26493762/yosemite-php-gd-mcrypt-installation/26505558#26505558
      - `brew install php55`
      - `brew install php55-mcrypt`
        - `/usr/local/etc/php/5.5/conf.d/ext-mcrypt.ini` was created, do not forget to remove it upon extension removal.

6. The Web Folder
  - `$ mkdir ~/Web`
  - `$ git clone git@github.com:gigony/webapps_repository.git ./`
  - You can find and refer some configuration files in `config` folder.

7. httpd-vhosts.conf
  - Edit /private/etc/apache2/extra/httpd-vhosts.conf:
  - Delete everything after line 22 and paste this (replace YOURUSERNAME with your home directory’s name):

     	 <Directory "/Users/YOURUSERNAME/Web">
            Options Indexes MultiViews FollowSymLinks
            AllowOverride All
            Order allow,deny
            Allow from all
            Require all granted
          </Directory>
          <Virtualhost *:80>
              VirtualDocumentRoot "/Users/YOURUSERNAME/Web/_localhost"
              UseCanonicalName Off
          </Virtualhost>
         <Virtualhost *:80>
             VirtualDocumentRoot "/Users/YOURUSERNAME/Web/%2"
             ServerName sites.dev
             ServerAlias www.*.dev
             ServerAlias www.*.dev.*.xip.io
             UseCanonicalName Off
          </Virtualhost>
          <Virtualhost *:80>
              VirtualDocumentRoot "/Users/YOURUSERNAME/Web/%1"
              ServerName sites.dev
              ServerAlias *.dev
              ServerAlias *.dev.*.xip.io
              UseCanonicalName Off
          </Virtualhost>

8. Install MySQL
  - `$ brew install mysql`
  - `$ mysql.server restart`
  - `$ mysql_secure_installation`
  - Paste this into your Terminal to create a new database:

         $ mysql.server stop
         $ mysql_install_db --verbose --user=`whoami` --basedir="$(brew --prefix mysql)" --datadir=/usr/local/var/mysql --tmpdir=/tmp

  -   - OS X expects the MySQL socket to sit in /var/mysql, so we create that folder and add a symbolic link to where the socket actually lives:

         $ sudo mkdir /var/mysql
         $ sudo chmod 755 /var/mysql
         $ sudo ln -s /tmp/mysql.sock /var/mysql/mysql.sock

  -   - Now try starting the MySQL server:
    - `mysql.server start`
9. Done
  - You can now start Apache and MySQL like this:
    - `$ mysql.server start`
    - `$ sudo apachectl restart`

If everything has worked out, every folder you create in ~/Web like, say:

`~/Web/myawesomesite`

… will automatically be accessible as a .dev domain on your local machine as both:

`myawesomesite.dev`

… and:

`www.myawesomesite.dev`

And because you always want to test your sites on dozens of mobile devices and legacy windows machines, you can now also access it from other devices on your local network:

`myawesomesite.dev.X.X.X.X.xip.io`

…where X.X.X.X is, of course, your computer’s IP address.

If your router’s DNS blocks the xip.io service, you can set up Google’s DNS (8.8.8.8) on your devices so they can find your Mac’s server.

> REMEMBER: All of your sites are now easily accessible on the local network through xip.io mapping. So maybe you don’t want to run this when you’re in an untrusted local network (which you should never be in anyway).
You could also add HTTP authentication or other measures that you would use on a live site for access protection.


SETUP for PHP
--------------

**Some statements were inserted in `/private/etc/apache2/httpd.conf`:**

    AddType application/x-httpd-php .php .php3 .phtml .ph .inc
    AddType application/x-httpd-php-source .phps


**Enabled 'register_globals=on':**

Reference: http://www.kaffeetalk.de/using-register_globals-in-php-5-5/
  
*In /usr/share/php/register_globals.php*
  
    <?php
    extract($_REQUEST);
    extract($_SERVER);
    extract($_SESSION);
    extract($_GET);
    extract($_POST);    
    function session_register($name){
          global $$name;
          $_SESSION[$name] = $$name;
          $$name = &$_SESSION[$name]; 
    }
    function session_is_registered($x) {return isset($_SESSION[$x]);}
    function session_unregister($name){
    	global $$name;
    	unset($_SESSION[$name]);
    	unset($$name);
    }
    ?>

**Some statements were changed in `/usr/local/etc/php/5.5/php.ini`:**

    short_open_tag = On  // line 202
    error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE // line 452
    display_errors = On  //line 469
    auto_prepend_file = '/usr/share/php/register_globals.php' // line 667

Applications
==============
from http://dl.acm.org/citation.cfm?id=2610399 and http://people.csail.mit.edu/akiezun/ISSTA08-apollo.pdf
- faqforge 1.3.2
  - http://sourceforge.net/projects/faqforge
- aphpkb 0.95.8
  - http://aphpkb.sourceforge.net
- school mate 1.5.4
  - http://schoolmate.sourceforge.net
- phpsysinfo 3.2.0 (didn't work well)
  - http://phpsysinfo.sourceforge.net
- timeclock 1.0.4
  - http://timeclock.sourceforge.net
- webchess 1.0.0rc2
  - http://webchess.sourceforge.net
- opencart 2.0.1.1
  - http://www.opencart.com


from http://www.brandingly.org/10-open-source-php-e-commerce-applications/
- opencart
  - http://www.opencart.com/?route=demonstration/demonstration
  

Application Setup
====================

added an account in mysql.
- id: test
- pw: test

To run mysql as root, use this command:
`$ mysql -u root -p`

To run mysql as a test user, use this command:
`$ mysql -u test -p`


##### Measuring lines of code (LOC) : http://cloc.sourceforge.net/

     $ ./cloc-1.62.pl [web application folder]


faqforge
--------
#### DB Setup
`create database faqforge;`

`GRANT ALL on faqforge.* to test;`

removed `DEFAULT '0'` for id in `faqforge.sql` file.

#### Issues

- `session_register` function issue
  - http://stackoverflow.com/questions/3682615/how-to-fix-the-session-register-deprecated-issue
  - http://php.net/manual/en/function.session-is-registered.php

#### Info
      29 text files.
      25 unique files.
      15 files ignored.

	http://cloc.sourceforge.net v 1.62  T=0.14 s (153.1 files/s, 13787.5 lines/s)
	-------------------------------------------------------------------------------
	Language                     files          blank        comment           code
	-------------------------------------------------------------------------------
	PHP                             19            190            469           1056
	CSS                              1             23              1            126
	SQL                              1              2              0             24
	-------------------------------------------------------------------------------
	SUM:                            21            215            470           1206
	-------------------------------------------------------------------------------

aphpkb
------

#### DB Setup
`create database akb;`

`GRANT ALL on akb.* to test;`

#### Permission
    sudo chown -R _www:_www ./aphpkb 
    chmod -R 755 ./aphpkb
    cd aphpkb
    chmod -R 600 ./attach

Apache server's user and group name : http://serverfault.com/questions/152175/apache-runs-as-which-user-group-under-os-x-10-6)


#### Configuration
- Knowledgebase URL: http://aphpkb.dev/kb/
- No plugins
- Error handling : production level
- KB Admin Account Details
  - password: test

    	DB_USER = test
	    DB_PASSWORD = test 
    	DB_HOST = localhost 
    	DB_NAME = akb
    	DB_MAX_REC = 5
    	KB_NAME = aphpkb
    	KB_URL = http://aphpkb.dev/kb/
    	KB_HOME_URL = http://www.aphpkb.org
    	PLUGINHTML = 
    	PLUGIN_RSS = 
    	PLUGINMAA = 
    	PRODLEV = 1

    	Admin First/Last Name = Gigon Bae
    	Admin Email Address = gigony@gmail.com
    	Admin Password = test

#### Issues

Had some grammar errors in source code
  - http://sourceforge.net/projects/aphpkb/reviews
    - `$u = escdata(xss_clean(($_POST['username']));` should be `$u = escdata(xss_clean(($_POST['username'])));` in login.php(line 27) and in register.php(line 40)
    
### Info

          61 text files.
          59 unique files.
           6 files ignored.

    http://cloc.sourceforge.net v 1.62  T=0.36 s (151.6 files/s, 15655.5 lines/s)
    -------------------------------------------------------------------------------
    Language                     files          blank        comment           code
    -------------------------------------------------------------------------------
    PHP                             47           1021            291           3020
    Javascript                       3             11             18           1090
    HTML                             3             22             15            133
    SQL                              1              5              1             51
    XML                              1              1              0              0
    -------------------------------------------------------------------------------
    SUM:                            55           1060            325           4294
    -------------------------------------------------------------------------------

schoolmate
----------

#### DB Setup
  - changed `TYPE=MyISAM` TO `ENGINE=MyISAM` because `TYPE` is deprecated as MySQL is upgraded.
    - http://stackoverflow.com/questions/12428755/1064-error-in-create-table-type-myisam
  - `$ mysql -u root -p < SchoolMate.sql`
  - `GRANT ALL on schoolmate.* to test;`
- Code change
  - Open index.php that you extracted with your favorite text editor and change the dbuser and dbpass variables to the username and password you just created.
        $dbuser     = 'test';         // databse username
        $dbpass     = 'test';         // databse password
        $dbname     = 'schoolmate';           // name of the database you are using


Current admin's id/pass is `test/test`

#### Info

          67 text files.
          67 unique files.
           3 files ignored.

    http://cloc.sourceforge.net v 1.62  T=0.32 s (197.0 files/s, 26075.0 lines/s)
    -------------------------------------------------------------------------------
    Language                     files          blank        comment           code
    -------------------------------------------------------------------------------
    PHP                             63           1200            427           6554
    SQL                              1             55              0            233
    -------------------------------------------------------------------------------
    SUM:                            64           1255            427           6787
    -------------------------------------------------------------------------------

phpsysinfo (didn't work well)
-----------

Just decompress and untar the source (which you should have done by now,
if you're reading this...), into your webserver's document root.

There is a configuration file called phpsysinfo.ini.new. If this a brand new
installation, you should copy this file to phpsysinfo.ini and edit it.

- make sure your `php.ini` file's `include_path` entry contains "."
- make sure your `php.ini` has `safe_mode` set to 'off'.

phpSysInfo require php-xml extension.

Please keep in the mind that because phpSysInfo requires access to many
files in `/proc` and other system binary you **MUST DISABLE** `php's safe_mode`.
Please see the PHP documentation for information on how you
can do this.


To disable safe_mode in php 5, i used this:
  - http://www.crucialp.com/resources/tutorials/server-administration/customizing-php-safe-mode/
  - put `php_admin_flag safe_mode Off` in `/private/etc/apache2/extra/httpd-vhosts.conf`
  
In php.ini
    ; I added this
    safe_mode = Off
    include_path = "."

#### Info
     513 text files.
     498 unique files.
     240 files ignored.

    http://cloc.sourceforge.net v 1.62  T=3.39 s (80.6 files/s, 22306.1 lines/s)
    -------------------------------------------------------------------------------
    Language                     files          blank        comment           code
    -------------------------------------------------------------------------------
    Javascript                      38           5031           6807          25310
    XML                            111              0            432          14811
    PHP                             81           1065           6731          10963
    CSS                             20            248             57           1405
    XSLT                             1              2              1           1149
    HTML                            15             24             30            873
    XSD                              3             34              2            484
    Bourne Shell                     2             10              6             31
    JSON                             1              0              0             18
    DOS Batch                        1              0              0             10
    -------------------------------------------------------------------------------
    SUM:                           273           6414          14066          55054
    -------------------------------------------------------------------------------

timeclock
----------

** Original instructions **
- Unpack the distribution into your webserver's document root directory.
- Create a database named "timeclock" or whatever you wish to name it.
- Create a mysql user named "timeclock" (or whatever you wish to name it) with a password. Give this user at least SELECT, UPDATE, INSERT, DELETE, ALTER, and CREATE privileges to ONLY this database.
- Import the tables using the create_tables.sql script included in the distribution.
- Edit config.inc.php.
- Open index.php with your web browser.
- Click on the Administration link on the right side of the page. Input "admin" (without the quotes) for the username and "admin" (without the quotes) for the password. Please change the password for this admin user after the initial setup of PHP Timeclock is complete.
- Create at least one office by clicking on the Create Office link on the left side of the page. You MUST create an office to achieve the desired results. Create more offices if needed.
- Create at least one group by clicking on the Create Group link on the left side of the page. You MUST create a group to achieve the desired results. Create more groups if needed.
- Add your users by clicking on the Create New Users link, and assign them to the office(s) and group(s) you created above. Give Sys Admin level access for users who will administrate PHP Timeclock. Give Time Admin level access for users who will need to edit users' time, but who will not need Sys Admin level access. If you require the reports to be secured so only certain users can run them, then give these users reports level access.

 Admin level access and reports level access are completely separate from each other. Just because a user has admin level access does not give that user reports level access. You must specifically give them reports level access when you are creating or editing the users, if you choose to secure these reports for these users. To make PHP Timeclock lock down the reports to only these users, set the use_reports_password setting in config.inc.php to "yes".


** Setup procedure **

1. make a database `timeclock` and provide access authorization.
  - `create database timeclock;`
  - `GRANT ALL on timeclock.* to test;`
2. Modifiy `create_tables.sql`
  - insert `use timeclock;` at the first of the file.
  - change `TYPE=MyISAM` to `ENGINE=MyISAM`
  - change `INSERT INTO employees VALUES ('admin', NULL, 'xy.RY2HT1QTc2', 'administrator', '', '', '', 1, 1, 1, '');` to `INSERT INTO employees VALUES ('admin', NULL, 'xy.RY2HT1QTc2', 'administrator', '', '', '', 1, 1, 1, 0);`
  - change `timestamp timestamp(14) NOT NULL,` to `timestamp timestamp(6) NOT NULL,`
3. `$ mysql -u root -p < create_tables.sql`
4. Edit config.inc.php.
       $db_hostname = "localhost";
       $db_username = "test";
       $db_password = "test";
       $db_name = "timeclock";
5. run webbrowser


> The followings are needed to give a proper configuration:
- Click on the Administration link on the right side of the page. Input "admin" (without the quotes) for the username and "admin" (without the quotes) for the password. Please change the password for this admin user after the initial setup of PHP Timeclock is complete.
- Create at least one office by clicking on the Create Office link on the left side of the page. You MUST create an office to achieve the desired results. Create more offices if needed.
- Create at least one group by clicking on the Create Group link on the left side of the page. You MUST create a group to achieve the desired results. Create more groups if needed.
- Add your users by clicking on the Create New Users link, and assign them to the office(s) and group(s) you created above. Give Sys Admin level access for users who will administrate PHP Timeclock. Give Time Admin level access for users who will need to edit users' time, but who will not need Sys Admin level access. If you require the reports to be secured so only certain users can run them, then give these users reports level access.

#### Info
          77 text files.
          74 unique files.
           6 files ignored.

    http://cloc.sourceforge.net v 1.62  T=0.67 s (106.3 files/s, 35374.4 lines/s)
    -------------------------------------------------------------------------------
    Language                     files          blank        comment           code
    -------------------------------------------------------------------------------
    PHP                             63           2477            877          17446
    Javascript                       4            182            599           1474
    CSS                              2              2              0            278
    SQL                              2             69              0            220
    -------------------------------------------------------------------------------
    SUM:                            71           2730           1476          19418

webchess
---------

### DB Setup
- `create database webchess;`
- `GRANT ALL on webchess.* to test;`

### Permission
- `$ sudo chown -R _www:_www ./webchess`
- `$ sudo chmod -R 755 ./webchess`

### http://webchess.dev/install.php
      Server: localhost
      User:	test
      Password:	test
      Database name: webchess

#### Info

          55 text files.
          55 unique files.
          12 files ignored.

    http://cloc.sourceforge.net v 1.62  T=0.41 s (105.9 files/s, 25723.1 lines/s)
    -------------------------------------------------------------------------------
    Language                     files          blank        comment           code
    -------------------------------------------------------------------------------
    PHP                             30            876            978           4716
    Javascript                      10            386            510           2253
    CSS                              3            114             56            552
    -------------------------------------------------------------------------------
    SUM:                            43           1376           1544           7521
    -------------------------------------------------------------------------------

opencart
--------

#### DB Setup
  - `create database opencart;`
  - `GRANT ALL on opencart.* to test;`

#### Permission
      chmod 755 system/cache/
      chmod 755 system/logs/
      chmod 755 system/download/
      chmod 755 system/upload/
      chmod 755 image/
      chmod 755 image/cache/
      chmod 755 image/catalog/
      chmod 755 config.php    => after copying config-dist.php to config.php
      chmod 755 admin/config.php  => after copying config-dist.php to config.php
      sudo chown -R _www:_www *
      

#### Launch install module
  - http://opencart.dev/install/
  - admin id/pass = admin/admin
  
#### Run
  - http://opencart.dev/admin/


#### Info

        1789 text files.
        1737 unique files.
          79 files ignored.

    http://cloc.sourceforge.net v 1.62  T=11.25 s (150.0 files/s, 27187.1 lines/s)
    -------------------------------------------------------------------------------
    Language                     files          blank        comment           code
    -------------------------------------------------------------------------------
    PHP                            959          29732           2791         110212
    Smarty                         452           2340              0          64210
    CSS                             33           1356            320          31651
    Javascript                      84           5928           5613          25172
    LESS                            94           1196           1564           8507
    SQL                              1            500            690           6601
    SASS                            23             42             55           3143
    HTML                            29            727             27           2941
    JSON                             8              0              0            332
    Bourne Shell                     1              4              0             34
    XML                              2              1              0             23
    make                             1              4              2              6
    -------------------------------------------------------------------------------
    SUM:                          1687          41830          11062         252832
    -------------------------------------------------------------------------------


DB Backup/Restore
=================

Current DB backups are located in `config/db` folder.

Backup
------
     mysqldump --opt -u test -p faqforge >faqforge.sql
     mysqldump --opt -u test -p akb >akb.sql
     mysqldump --opt -u test -p opencart >opencart.sql
     mysqldump --opt -u test -p schoolmate >schoolmate.sql
     mysqldump --opt -u test -p timeclock > timeclock.sql
     mysqldump --opt -u test -p webchess > webchess.sql
     
Restore
--------
     mysql -u test -p faqforge < faqforge.sql
     mysql -u test -p akb < akb.sql
     mysql -u test -p opencart < opencart.sql
     mysql -u test -p schoolmate < schoolmate.sql
     mysql -u test -p timeclock < timeclock.sql
     mysql -u test -p webchess < webchess.sql
     