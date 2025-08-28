# Procurement Assistant System

A web application built with pure PHP to automate and streamline the entire procurement process, connecting buyers with relevant suppliers. The system is designed to improve transparency, reduce costs, and speed up delivery.

## Key Features

*   **Role-Based Access Control:** Separate, secure workflows and dashboards for three distinct user roles:
    *   **Admins:** Manage the entire system, including users, suppliers, product categories, brands, and global settings.
    *   **Buyers:** Create purchase requests for goods and services.
    *   **Suppliers:** Register their company and services to receive and respond to relevant purchase requests.
*   **Full Procurement Cycle:**
    *   Buyers create detailed purchase requests.
    *   The system automatically matches requests to suppliers based on their registered categories and brands.
    *   Suppliers are notified and can submit detailed proposals, including optional PDF invoice uploads.
    *   Buyers can compare all submitted proposals side-by-side and award the contract to the winning supplier.
*   **Automated Notification System:** A real-time notification system keeps all parties informed of key events, such as new requests, new proposals, and award decisions.

## Tech Stack

*   **Backend:** PHP (no frameworks)
*   **Database:** MySQL
*   **Frontend:** HTML, CSS (minimal styling for easy customization)

## Local Setup & Installation

Follow these steps to get the project running on your local machine.

### 1. Prerequisites

*   PHP 7.4 or higher
*   A MySQL or MariaDB database server

### 2. Database Setup

1.  Create a new database in your MySQL server. For example, `procurement_db`.
2.  Import the database schema by running the contents of the `database.sql` file located in the project root. This will create all the necessary tables.

    ```bash
    mysql -u your_username -p procurement_db < database.sql
    ```

### 3. Application Configuration

1.  Open the `config/config.php` file.
2.  Update the database credentials (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`) to match your local environment.

    ```php
    // Example configuration
    define('DB_HOST', '127.0.0.1');
    define('DB_NAME', 'procurement_db');
    define('DB_USER', 'root');
    define('DB_PASS', 'your_password'); // <-- Change this
    ```

### 4. Running the Application

1.  Navigate to the project's root directory in your terminal.
2.  Start the PHP built-in web server, pointing it to the `public` directory as the document root.

    ```bash
    php -S localhost:8000 -t public
    ```
3.  The application will now be running at `http://localhost:8000`.

## How to Use the System

1.  **Create the First Admin Account:** Navigate to `http://localhost:8000/register`. This form is only available if no other Admin account exists. Fill it out to create the master administrator.
2.  **Log in as Admin:** Go to `http://localhost:8000/login` and log in with your new admin credentials.
3.  **Set up the System:** In the Admin Dashboard, create some **Product Categories** and **Product Brands**. You can also create **Buyer** accounts for your procurement team.
4.  **Register a Supplier:** Log out and go to `http://localhost:8000/supplier/register` to register a new supplier company. Select the categories and brands this supplier services.
5.  **Approve the Supplier:** Log back in as the Admin and navigate to the **Supplier Approval** page to approve the new supplier.
6.  **Start a Procurement Cycle:** Log in as a Buyer and create a new **Purchase Request**. The system will automatically match and notify the approved supplier.
7.  **Submit a Proposal:** Log in as the Supplier, view the new request on your dashboard, and submit a proposal.
8.  **Award the Contract:** Log back in as the Buyer. You will see a notification about the new proposal. View the request to see the comparison table and award the contract to the supplier. Both suppliers will be notified of the outcome.
