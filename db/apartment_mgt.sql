-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 10, 2023 at 11:57 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apartment_mgt`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `id` int(11) NOT NULL,
  `first_name` text DEFAULT NULL,
  `last_name` text DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Invoices`
--

CREATE TABLE `Invoices` (
  `id` int(11) NOT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `due_date` date NOT NULL,
  `current_bill` decimal(10,2) DEFAULT NULL,
  `prev_bill` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'Pending' CHECK (`status` in ('Pending','Paid','Overdue'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `Invoices`
--
DELIMITER $$
CREATE TRIGGER `before_invoice_insert` BEFORE INSERT ON `Invoices` FOR EACH ROW BEGIN
    DECLARE prev_bill DECIMAL(10,2);

    -- Get the previous balance of the tenant
    SELECT balance INTO prev_bill
    FROM Tenants
    WHERE id = NEW.tenant_id;

    -- If the previous balance is NULL, set it to 0
    IF prev_bill IS NULL THEN
        SET prev_bill = 0.00;
    END IF;

    -- Calculate the total amount
    SET NEW.total_amount = NEW.current_bill + prev_bill;

    -- Update the tenant's balance with the new total amount
    UPDATE Tenants
    SET balance = NEW.total_amount
    WHERE id = NEW.tenant_id;

    -- Set the prev_bill column in Invoices
    SET NEW.prev_bill = prev_bill;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Payments`
--

CREATE TABLE `Payments` (
  `id` int(11) NOT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `Payments`
--
DELIMITER $$
CREATE TRIGGER `after_payment_insert` AFTER INSERT ON `Payments` FOR EACH ROW BEGIN
    DECLARE remaining_balance DECIMAL(10,2);

    -- Get the remaining balance of the tenant
    SELECT balance INTO remaining_balance
    FROM Tenants
    WHERE id = NEW.tenant_id;

    -- If the remaining balance is NULL, set it to 0
    IF remaining_balance IS NULL THEN
        SET remaining_balance = 0.00;
    END IF;

    -- Deduct the amount paid from the remaining balance
    SET remaining_balance = remaining_balance - NEW.amount_paid;

    -- Update the tenant's balance with the new remaining balance
    UPDATE Tenants
    SET balance = remaining_balance
    WHERE id = NEW.tenant_id;

    -- Mark the corresponding invoice as Paid
    UPDATE Invoices
    SET status = 'Paid'
    WHERE id = NEW.invoice_id;

    -- Check if the balance is negative and update accordingly
    IF remaining_balance < 0 THEN
        -- You can add additional logic here, such as sending notifications or logging
        -- For simplicity, we set the balance to negative, but you may want to handle this differently based on your application's requirements
        UPDATE Tenants
        SET balance = remaining_balance
        WHERE id = NEW.tenant_id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Rooms`
--

CREATE TABLE `Rooms` (
  `id` int(11) NOT NULL,
  `rent` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'Available' CHECK (`status` in ('Available','Occupied','Under Maintenance'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Tenants`
--

CREATE TABLE `Tenants` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `move_in_date` date NOT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `Maintenance` (
    `id` int(11) NOT NULL,
    `tenant_id` int(11) NOT NULL,
    `description` text NOT NULL,
    `status` varchar(50) DEFAULT 'Pending' CHECK (`status` in ('Pending','Approved','Denied')),
    `schedule_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Triggers `Tenants`
--
DELIMITER $$
CREATE TRIGGER `after_tenant_delete` AFTER DELETE ON `Tenants` FOR EACH ROW BEGIN
    IF OLD.room_id IS NOT NULL THEN
        UPDATE Rooms
        SET status = 'Available'
        WHERE id = OLD.room_id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_tenant_insert` AFTER INSERT ON `Tenants` FOR EACH ROW BEGIN
    IF NEW.room_id IS NOT NULL THEN
        UPDATE Rooms
        SET status = 'Occupied'
        WHERE id = NEW.room_id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_tenant_update` AFTER UPDATE ON `Tenants` FOR EACH ROW BEGIN
    IF NEW.room_id IS NOT NULL AND NEW.room_id != OLD.room_id THEN
        -- Mark the new room as 'Occupied'
        UPDATE Rooms
        SET status = 'Occupied'
        WHERE id = NEW.room_id;

        -- Mark the old room as 'Available'
        UPDATE Rooms
        SET status = 'Available'
        WHERE id = OLD.room_id;
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Invoices`
--
ALTER TABLE `Invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`);


  
ALTER TABLE `Maintenance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `Payments`
--
ALTER TABLE `Payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `Rooms`
--
ALTER TABLE `Rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Tenants`
--
ALTER TABLE `Tenants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `Maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Invoices`
--
ALTER TABLE `Invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Payments`
--
ALTER TABLE `Payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Rooms`
--
ALTER TABLE `Rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Tenants`
--
ALTER TABLE `Tenants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Invoices`
--
ALTER TABLE `Invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `Tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Payments`
--
ALTER TABLE `Payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `Tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`invoice_id`) REFERENCES `Invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Tenants`
--
ALTER TABLE `Tenants`
  ADD CONSTRAINT `tenants_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `Rooms` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
