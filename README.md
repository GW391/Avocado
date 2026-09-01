# Avocado CMS

**A lightweight, self-hosted content management system written in PHP.**

Avocado CMS is designed to be straightforward to install and use while providing the features needed to manage and publish content securely.

**Project website:** [avocadocms.ddns.net](https://avocadocms.ddns.net)

The project began as a way to learn PHP and gradually developed into a more complete CMS through experimentation, feature requests and continued development.

## Features

Avocado CMS includes:

- Content creation and editing
- Scheduled article publishing
- Podcast publishing with RSS podcast feeds
- Newsletter support
- Customisable skins
- Configurable menus
- Cross-site scripting (XSS) protection
- Session hijacking protection
- Distributed brute-force login mitigation
- Additional content-management and administration features

## Requirements

To run Avocado CMS you will need:

- [PHP](https://www.php.net/) 7 or later
- [MySQL](https://www.mysql.com/) 8 or later, or [MariaDB](https://mariadb.org/) 10 or later
- A web server capable of running PHP, such as [Apache HTTP Server](https://httpd.apache.org/), [Nginx](https://nginx.org/) or [Microsoft IIS](https://www.iis.net/)
- A [TinyMCE Cloud](https://www.tiny.cloud/) account

For new installations, use currently supported versions of PHP, your database server and your web server rather than end-of-life releases.

## Third-Party Components

Avocado CMS includes the following third-party open-source components:

- [HTML Purifier](https://htmlpurifier.org/) 4.15.0 — HTML filtering and sanitisation
- [PHPMailer](https://github.com/PHPMailer/PHPMailer) 7.1.1 — email creation and delivery

These projects are developed independently of Avocado CMS and remain subject to their respective licences.

## Installation

### 1. Copy Avocado to your web server

Copy the `Avocado` directory to the location from which you want to host the CMS.

The directory can be renamed if required.

Configure your web server so that the directory is available through your website and is able to execute PHP scripts.

### 2. Configure permissions

Your web server must be able to access the files and directories required by Avocado.

Public website users only need access to resources intended to be served by the web server, including:

- The site root
- CSS files
- Images
- The podcast directory, if podcast functionality is being used

File-system and web-server permissions should be configured appropriately for your hosting environment.

### 3. Start the setup process

Open the Avocado installation directory in your web browser.

If Avocado has not yet been configured, the setup page will be displayed automatically.

The installer will ask for the information required to configure the CMS.

### 4. Configure the database

You will need the connection details for your MySQL or MariaDB server, including:

- Database server hostname
- Database server port
- Administrative/root database username
- Administrative/root database password

You will then choose:

- A database name
- A database username
- A database password

Avoid special characters in the database name and database username.

Avocado will use this information to create and configure its database.

> **Security note:** The database administrative/root credentials are required during setup. They should not be used by the CMS for normal operation after installation. The Databse username and Password you create during the install process will be crearted with only the permissions Avocado requires possible. Use this account wherever possbile when access the data.

### 5. Create your Avocado administrator

During setup you will also choose the username and password used to administer your Avocado CMS installation.

Use a strong, unique password for this account.

### 6. Encryption keys

Avocado generates database encryption keys during installation.

The keys are unique to each installation and are not shared with other Avocado sites.

**Keep these keys safe.**

Changing an encryption key after data has been encrypted with it may make that data unreadable.

### 7. Complete the installation

Avocado will create the required database structure and populate it with the default configuration and menus.

A new installation includes a default:

- Homepage
- Calendar
- Login menu

Additional administration menus become available after you sign in.

Once setup has completed, continue to the login page and sign in using the Avocado administrator account created during installation.

You can then begin configuring your site and publishing content.

## Security

Security has been an important consideration during the development of Avocado.

The CMS includes mechanisms intended to help protect against common web application attacks, including:

- Cross-site scripting (XSS)
- Session hijacking
- Distributed brute-force login attempts

Avocado also uses HTML Purifier when sanitising HTML content.

These features should be used alongside normal server-security practices. Keep PHP, your database server, web server and other dependencies up to date, use HTTPS, restrict file-system permissions appropriately and use strong, unique credentials.

No web application should be considered secure solely because security controls are built into the application.

If you discover a security issue, please report it responsibly rather than publishing exploit details before a fix can be developed.

## Project Status

Avocado CMS is an open-source project under active development.

It has grown over a number of years from a learning project into a functional content management system. There are still areas that can be improved, modernised and documented.

Feedback, testing and contributions are welcome.

If you use Avocado, please consider reporting problems or suggesting improvements through the project's [GitHub repository](https://github.com/GW391/Avocado).

## Project History

Avocado started with a simple goal: **learn PHP by building something useful.**

The original project was a single web page. That page gradually became a basic content manager, and the content manager continued to grow as new features were requested and new techniques were learned.

Over time, that learning exercise developed into the CMS available here today.

The project has now been made publicly available so that development and learning can continue in the open.

Avocado is not intended to pretend that history does not exist — it is a project that has evolved through experimentation and practical use. Publishing the source provides an opportunity to improve it further through feedback, contributions and new ideas.

## Contributing

Contributions are welcome.

There are several ways you can help:

- Report bugs
- Suggest new features
- Improve documentation
- Test Avocado on different PHP, database and web-server configurations
- Review existing code
- Submit fixes and improvements

Issues and pull requests can be submitted through the [Avocado GitHub repository](https://github.com/GW391/Avocado).

When reporting a problem, please include as much relevant information as possible, such as:

- PHP version
- MySQL or MariaDB version
- Web server
- Operating system
- Steps required to reproduce the problem
- Any relevant error messages

Please **do not** include passwords, encryption keys, database credentials or other sensitive information in issues.

## Licence

Avocado CMS is open-source software released under the **GNU General Public License v3.0 (GPL-3.0)**.

See the [`LICENSE`](LICENSE) file for the full licence terms.

---

Thanks for trying Avocado CMS.

If you find a bug, have an idea for an improvement or simply want to experiment with the project, contributions and feedback are welcome.
