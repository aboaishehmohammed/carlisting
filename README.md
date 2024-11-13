
# Car Store Management System

This Yii2-based car store management application features a buyer portal for browsing and purchasing cars and an admin panel for managing car listings, sales data, and CSV exports. The application uses repository and service design patterns, integrates background job processing for exports, and supports role-based access for admin and buyer users.

## Table of Contents
- [Setup Instructions](#setup-instructions)
- [Virtual Host Configuration](#virtual-host-configuration)
- [Creating an Admin User via Console](#creating-an-admin-user-via-console)
- [Code Structure and Design Decisions](#code-structure-and-design-decisions)
- [Implemented Features](#implemented-features)
- [Known Issues](#known-issues)
- [Suggestions for Further Improvements](#suggestions-for-further-improvements)

## Setup Instructions

### Prerequisites

- **PHP** (version 7.x or higher)
- **Composer** (for managing dependencies)
- **MySQL** (for the database)
- **Yii2 Queue** configured with a database backend for background jobs
- **Apache** with virtual hosts for local development

### Installation

1. **Clone the Repository**:
   ```bash
   git clone [https://github.com/aboaishehmohammed/carlisting.git]
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   ```

3. **Initialize Yii Environment**:
   Run the Yii initialization command to set up the environment:
   ```bash
   php init
   ```
   Choose `Development` for local development setup.

4. **Database Migration**:
   ```bash
   php yii migrate
   ```

7. **Background Job Setup**:
   Ensure the `queue` table is created for the database-backed queue system:
   Start the Yii queue worker to process background jobs:
   ```bash
   php yii queue/listen
   ```

## Virtual Host Configuration

For local development, set up virtual hosts to access the storefront and dashboard as separate applications.

1. **Configure Virtual Hosts**:
   Add configuration to your Apache `httpd-vhosts.conf` file example:

   ```apache
   <VirtualHost *:80>
       ServerName syarah-task.local
       DocumentRoot "C:/xampp/htdocs/syarah-task/storefront/web"
       <Directory "C:/xampp/htdocs/syarah-task/storefront/web">
           RewriteEngine On
           RewriteCond %{REQUEST_FILENAME} !-f
           RewriteCond %{REQUEST_FILENAME} !-d
           RewriteRule . index.php
           Require all granted
       </Directory>
   </VirtualHost>

   <VirtualHost *:80>
       ServerName task-admin.local
       DocumentRoot "C:/xampp/htdocs/syarah-task/dashboard/web"
       <Directory "C:/xampp/htdocs/syarah-task/dashboard/web">
           RewriteEngine On
           RewriteCond %{REQUEST_FILENAME} !-f
           RewriteCond %{REQUEST_FILENAME} !-d
           RewriteRule . index.php
           Require all granted
       </Directory>
   </VirtualHost>
   ```

2. **Update `hosts` File**:
   Edit your `hosts` file (usually located at `C:\Windows\System32\drivers\etc\hosts` on Windows) and add the following entries:

   ```plaintext
   127.0.0.1 syarah-task.local
   127.0.0.1 task-admin.local
   ```

3. **Restart Apache**:
   After making these changes, restart Apache to apply the virtual host configuration.

4. **Access the Applications**:
   - Storefront (Buyer Portal): [http://syarah-task.local](http://syarah-task.local)
   - Dashboard (Admin Panel): [http://task-admin.local](http://task-admin.local)

## Creating an Admin User via Console

Admin users are created exclusively through a console command for security. To create an admin user, use the following command:

```bash
php yii admin/create <username> <password>
```

- Replace `<username>` with the desired username.
- Replace `<password>` with the desired password.

### Example

To create an admin user with the username `admin_user` and password `securepassword`, run:

```bash
php yii admin/create admin_user securepassword
```

### Notes

- **Duplicate Check**: The command checks if a user with the same username exists and shows an error if found.
- **Role Assignment**: The created user is assigned an `admin` role by default, ensuring access to admin-only features.
- **Secure Usage**: Admin creation is restricted to the console to prevent unauthorized access.

## Code Structure and Design Decisions

### Code Structure

- **Frontend (`storefront`)**:
  - **Controllers**: CarListingController for the home page and purchase car and DashboardController for buyer dashboard.
  - **Views**: Displays car listings, search filters, and buyer-specific content, such as the purchased cars dashboard.
  - **Models**: Uses the shared `CarListing` model located in `common`, and the `User` model for managing buyers.

- **Backend (`dashboard`)**:
  - **Controllers**: Manages CRUD operations for car listings, image uploads, and export functionalities.
  - **Views**: Admin-specific interfaces for managing car listings, viewing export history, and tracking job statuses.
  - **Models**: Includes `ExportJob` for managing export-related data specific to the admin panel.
  - **Services**:
    - `ImageService`: Handles image uploads for car listings.
    - `ExportService`: Manages the creation and tracking of export jobs.

- **Console**:
  - **Jobs**: `ExportCarListingsJob` in `console/jobs` handles background job execution, generating CSV exports for car listings. Each job’s status and file path are stored in the `ExportJob` table.

### Design Decisions

- **Repository and Service Pattern**: Separates data handling and business logic for modularity and scalability.
- **Database Queue for Background Jobs**: Yii2 Queue with a database backend processes export tasks asynchronously.
- **ExportJob Table**: Tracks the status and path of CSV exports, allowing admins to monitor job progress and download completed files.
- **Role-Based Access**: Controls access between admin and buyer roles within the `User` model.

## Implemented Features

1. **User Management**:
   - Default Yii2 user management modified to distinguish between admin and buyer roles.
   - Buyer registration enabled in the storefront.
   - Console-only creation of admin users for added security.

2. **Admin Panel**:
   - **Car Listing Management**: CRUD operations for car listings, with filtering, sorting, and status updates.
   - **Sales dashboard**: dashboard for admin to show sales
   - **Export Feature**: Generates CSV exports for car listings with optional filters. Jobs are processed in the background, with statuses (`pending`, `completed`, `failed`) shown in the export history.
   - **Background Jobs**: Export jobs run asynchronously using Yii2 Queue. Admins can view and download completed exports.

3. **Buyer Portal**:
   - **Car Browsing**: Buyers can browse, filter, and search car listings.
   - **Car Details**: View car details with a “Purchase” option (marks the car as sold).
   - **Buyer Dashboard**: Displays purchased cars specific to the logged-in buyer.

4. **Image Management**:
   - Images are stored in `dashboard/web/uploads/car_images` via `ImageService`, with a limit of 3 images per car listing.

### Known Issues

- **Image Access in Storefront**: Images saved in `dashboard/web/uploads/car_images` may require additional configuration to display in the storefront.
- **Limited Error Handling for Background Jobs**: Handling of job failures for large datasets may require further improvements.

## Suggestions for Further Improvements

1. **Enhanced Image Handling**: Implement an action or symlink in the storefront to access images saved in the dashboard’s `uploads` directory.
2. **Caching**: Add caching for frequently accessed pages like car listings and the sales dashboard to improve performance.
3. **Docker Support**: Add Docker configurations for easier setup and consistent deployment.
4. **Advanced Sales Analytics**: Expand the sales dashboard with additional reporting and visualization capabilities.
