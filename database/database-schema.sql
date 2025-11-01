-- ============================================================================
-- INOFA PLATFORM DATABASE SCHEMA (MySQL)
-- ============================================================================
-- This schema represents a complete freelance platform with user management,
-- project posting, bidding system, agreements, payments, messaging, and reviews.
-- ============================================================================

-- Set character set and collation for the database
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- ============================================================================
-- CORE TABLES
-- ============================================================================

-- Users table: Core user information for all platform users
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `role` ENUM('consumer', 'developer', 'admin') NOT NULL DEFAULT 'consumer',
  `avatar` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Profile avatar URL',
  `bio` TEXT NULL DEFAULT NULL COMMENT 'User biography',
  `location` VARCHAR(255) NULL DEFAULT NULL COMMENT 'User location',
  `dark_mode` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Chatify dark mode preference',
  `messenger_color` VARCHAR(7) NOT NULL DEFAULT '#5aa07f' COMMENT 'Chatify messenger color',
  `active_status` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'User online status',
  `provider` VARCHAR(255) NULL DEFAULT NULL COMMENT 'OAuth provider (google, github, etc)',
  `provider_id` VARCHAR(255) NULL DEFAULT NULL COMMENT 'OAuth provider ID',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  
  INDEX `idx_role_active_status` (`role`, `active_status`),
  INDEX `idx_email_verified_at` (`email_verified_at`),
  INDEX `idx_created_at` (`created_at`),
  INDEX `idx_provider_provider_id` (`provider`, `provider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Developer Profiles table: Extended profile information for developers
CREATE TABLE `developer_profiles` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` BIGINT UNSIGNED NOT NULL UNIQUE,
  `headline` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Professional headline',
  `experience` TEXT NULL DEFAULT NULL COMMENT 'Professional experience description',
  `rate_min_byproject` DECIMAL(15, 2) NULL DEFAULT NULL COMMENT 'Minimum project rate',
  `rate_max_byproject` DECIMAL(15, 2) NULL DEFAULT NULL COMMENT 'Maximum project rate',
  `availability` ENUM('available', 'busy', 'unavailable') NOT NULL DEFAULT 'available',
  `experience_years` INT NOT NULL DEFAULT 0 COMMENT 'Years of experience',
  `education` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Educational background',
  `certifications` TEXT NULL DEFAULT NULL COMMENT 'Professional certifications',
  `portfolio_links` JSON NULL DEFAULT NULL COMMENT 'Links to portfolio projects',
  `rating_average` DECIMAL(3, 2) NOT NULL DEFAULT 0 COMMENT 'Average rating (0-5)',
  `rating_count` INT NOT NULL DEFAULT 0 COMMENT 'Total number of ratings',
  `projects_completed` INT NOT NULL DEFAULT 0 COMMENT 'Number of completed projects',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  
  CONSTRAINT `fk_developer_profiles_user_id` FOREIGN KEY (`user_id`) 
    REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chk_devprof_rate_range` CHECK (`rate_min_byproject` <= `rate_max_byproject`),
  CONSTRAINT `chk_devprof_experience` CHECK (`experience_years` >= 0),
  CONSTRAINT `chk_devprof_rating` CHECK (`rating_average` >= 0 AND `rating_average` <= 5),
  
  INDEX `idx_availability_rating` (`availability`, `rating_average`),
  INDEX `idx_rating_count` (`rating_average`, `rating_count`),
  INDEX `idx_rate_range` (`rate_min_byproject`, `rate_max_byproject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Skills table: Master list of available skills
CREATE TABLE `skills` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL UNIQUE COMMENT 'Skill name (e.g., PHP, React)',
  `slug` VARCHAR(100) NOT NULL UNIQUE COMMENT 'URL-friendly slug',
  `category` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Skill category (e.g., Backend, Frontend)',
  `is_active` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Whether skill is available for selection',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  
  INDEX `idx_category_active` (`category`, `is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Skill User table: Many-to-many relationship between users and skills
CREATE TABLE `skill_user` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `skill_id` BIGINT UNSIGNED NOT NULL,
  `proficiency_level` TINYINT NOT NULL DEFAULT 1 COMMENT '1=Beginner, 2=Intermediate, 3=Advanced, 4=Expert',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  
  CONSTRAINT `fk_skill_user_user_id` FOREIGN KEY (`user_id`) 
    REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_skill_user_skill_id` FOREIGN KEY (`skill_id`) 
    REFERENCES `skills` (`id`) ON DELETE CASCADE,
  UNIQUE KEY `uq_user_skill` (`user_id`, `skill_id`),
  
  INDEX `idx_skill_proficiency` (`skill_id`, `proficiency_level`),
  INDEX `idx_user_proficiency` (`user_id`, `proficiency_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Portfolios table: Developer portfolio items
CREATE TABLE `portfolios` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL COMMENT 'Portfolio item title',
  `description` TEXT NOT NULL COMMENT 'Detailed description of the work',
  `image_url` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Portfolio item image',
  `project_url` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Link to live project',
  `technologies` JSON NULL DEFAULT NULL COMMENT 'Technologies used (JSON array)',
  `completed_at` DATE NULL DEFAULT NULL COMMENT 'Project completion date',
  `is_featured` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Whether to feature on profile',
  `sort_order` INT NOT NULL DEFAULT 0 COMMENT 'Display order',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  
  CONSTRAINT `fk_portfolios_user_id` FOREIGN KEY (`user_id`) 
    REFERENCES `users` (`id`) ON DELETE CASCADE,
  
  INDEX `idx_user_featured` (`user_id`, `is_featured`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Projects table: Project postings by consumers
CREATE TABLE `projects` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `consumer_id` BIGINT UNSIGNED NOT NULL COMMENT 'User who posted the project',
  `title` VARCHAR(255) NOT NULL COMMENT 'Project title',
  `description` TEXT NOT NULL COMMENT 'Detailed project description',
  `budget` DECIMAL(15, 2) NOT NULL COMMENT 'Project budget',
  `deadline` DATE NOT NULL COMMENT 'Project deadline',
  `status` ENUM('draft', 'open', 'in_progress', 'completed', 'cancelled') NOT NULL DEFAULT 'open',
  `views_count` INT NOT NULL DEFAULT 0 COMMENT 'Number of views',
  `is_featured` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Featured project',
  `requirements` JSON NULL DEFAULT NULL COMMENT 'Project requirements (JSON)',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  
  CONSTRAINT `fk_projects_consumer_id` FOREIGN KEY (`consumer_id`) 
    REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chk_projects_budget` CHECK (`budget` >= 0),
  
  INDEX `idx_status_created` (`status`, `created_at`),
  INDEX `idx_consumer_status` (`consumer_id`, `status`),
  INDEX `idx_budget_deadline` (`budget`, `deadline`),
  INDEX `idx_featured_status` (`is_featured`, `status`),
  INDEX `idx_deadline_status` (`deadline`, `status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Project Skills table: Many-to-many relationship between projects and required skills
CREATE TABLE `project_skills` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `project_id` BIGINT UNSIGNED NOT NULL,
  `skill_id` BIGINT UNSIGNED NOT NULL,
  `required_level` TINYINT NOT NULL DEFAULT 2 COMMENT '1=Beginner, 2=Intermediate, 3=Advanced, 4=Expert',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  
  CONSTRAINT `fk_project_skills_project_id` FOREIGN KEY (`project_id`) 
    REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_project_skills_skill_id` FOREIGN KEY (`skill_id`) 
    REFERENCES `skills` (`id`) ON DELETE CASCADE,
  UNIQUE KEY `uq_project_skill` (`project_id`, `skill_id`),
  
  INDEX `idx_skill_required_level` (`skill_id`, `required_level`),
  INDEX `idx_project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Offers table: Developer bids on projects
CREATE TABLE `offers` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `project_id` BIGINT UNSIGNED NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL COMMENT 'Developer making the offer',
  `proposed_price` DECIMAL(15, 2) NOT NULL COMMENT 'Proposed project price',
  `proposed_deadline` DATE NOT NULL COMMENT 'Proposed completion date',
  `cover_letter` TEXT NOT NULL COMMENT 'Developer cover letter/proposal',
  `milestones` JSON NULL DEFAULT NULL COMMENT 'Proposed milestones (JSON)',
  `status` ENUM('pending', 'accepted', 'rejected', 'withdrawn') NOT NULL DEFAULT 'pending',
  `accepted_at` TIMESTAMP NULL DEFAULT NULL COMMENT 'When offer was accepted',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  
  CONSTRAINT `fk_offers_project_id` FOREIGN KEY (`project_id`) 
    REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_offers_user_id` FOREIGN KEY (`user_id`) 
    REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chk_offers_price` CHECK (`proposed_price` >= 0),
  UNIQUE KEY `uq_project_user` (`project_id`, `user_id`),
  
  INDEX `idx_status_created` (`status`, `created_at`),
  INDEX `idx_user_status` (`user_id`, `status`),
  INDEX `idx_project_status_created` (`project_id`, `status`, `created_at`),
  INDEX `idx_accepted_at` (`accepted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Project Agreements table: Formal agreement between consumer and developer
CREATE TABLE `project_agreements` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `project_id` BIGINT UNSIGNED NOT NULL,
  `consumer_id` BIGINT UNSIGNED NOT NULL,
  `developer_id` BIGINT UNSIGNED NOT NULL,
  `offer_id` BIGINT UNSIGNED NOT NULL,
  `final_price` DECIMAL(15, 2) NOT NULL COMMENT 'Final agreed price',
  `start_date` DATE NOT NULL COMMENT 'Project start date',
  `end_date` DATE NOT NULL COMMENT 'Project end date',
  `status` ENUM('draft', 'active', 'completed', 'terminated', 'disputed') NOT NULL DEFAULT 'draft',
  `terms` TEXT NULL DEFAULT NULL COMMENT 'Agreement terms and conditions',
  `milestones` JSON NULL DEFAULT NULL COMMENT 'Project milestones (JSON)',
  `signed_at` TIMESTAMP NULL DEFAULT NULL COMMENT 'When agreement was signed',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  
  CONSTRAINT `fk_project_agreements_project_id` FOREIGN KEY (`project_id`) 
    REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_project_agreements_consumer_id` FOREIGN KEY (`consumer_id`) 
    REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_project_agreements_developer_id` FOREIGN KEY (`developer_id`) 
    REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_project_agreements_offer_id` FOREIGN KEY (`offer_id`) 
    REFERENCES `offers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chk_project_agreements_price` CHECK (`final_price` >= 0),
  
  INDEX `idx_status_start_date` (`status`, `start_date`),
  INDEX `idx_developer_status` (`developer_id`, `status`),
  INDEX `idx_consumer_status` (`consumer_id`, `status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Payments table: Payment transactions for project agreements
CREATE TABLE `payments` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `project_agreement_id` BIGINT UNSIGNED NOT NULL,
  `amount` DECIMAL(15, 2) NOT NULL COMMENT 'Payment amount',
  `type` ENUM('deposit', 'milestone', 'final', 'refund') NOT NULL DEFAULT 'deposit',
  `payment_method` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Payment method used',
  `consumer_payment_proof` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Payment proof document',
  `status` ENUM('pending', 'confirmed', 'transferred', 'failed', 'refunded') NOT NULL DEFAULT 'pending',
  `admin_confirmed` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Admin confirmed payment',
  `admin_confirmed_at` TIMESTAMP NULL DEFAULT NULL COMMENT 'When admin confirmed',
  `admin_transferred` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Admin transferred funds',
  `admin_transferred_at` TIMESTAMP NULL DEFAULT NULL COMMENT 'When admin transferred',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  
  CONSTRAINT `fk_payments_project_agreement_id` FOREIGN KEY (`project_agreement_id`) 
    REFERENCES `project_agreements` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chk_payments_amount` CHECK (`amount` >= 0),
  
  INDEX `idx_status_created` (`status`, `created_at`),
  INDEX `idx_admin_workflow` (`admin_confirmed`, `admin_transferred`),
  INDEX `idx_agreement_status` (`project_agreement_id`, `status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Reviews table: Reviews and ratings for completed projects
CREATE TABLE `reviews` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `project_id` BIGINT UNSIGNED NOT NULL,
  `consumer_id` BIGINT UNSIGNED NOT NULL COMMENT 'Consumer who wrote review',
  `developer_id` BIGINT UNSIGNED NOT NULL COMMENT 'Developer being reviewed',
  `rating` TINYINT NOT NULL COMMENT 'Rating 1-5',
  `comment` TEXT NULL DEFAULT NULL COMMENT 'Review comment',
  `rating_breakdown` JSON NULL DEFAULT NULL COMMENT 'Detailed rating breakdown (JSON)',
  `is_public` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Whether review is public',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  
  CONSTRAINT `fk_reviews_project_id` FOREIGN KEY (`project_id`) 
    REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_reviews_consumer_id` FOREIGN KEY (`consumer_id`) 
    REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_reviews_developer_id` FOREIGN KEY (`developer_id`) 
    REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chk_reviews_rating` CHECK (`rating` >= 1 AND `rating` <= 5),
  UNIQUE KEY `uq_project_consumer` (`project_id`, `consumer_id`),
  
  INDEX `idx_developer_rating` (`developer_id`, `rating`),
  INDEX `idx_consumer_id` (`consumer_id`),
  INDEX `idx_rating_created` (`rating`, `created_at`),
  INDEX `idx_developer_created` (`developer_id`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- MESSAGING TABLES
-- ============================================================================

-- Conversations table: Chat conversations between users
CREATE TABLE `conversations` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Conversation title',
  `type` ENUM('private', 'project', 'support') NOT NULL DEFAULT 'private',
  `project_id` BIGINT UNSIGNED NULL DEFAULT NULL COMMENT 'Associated project (if type=project)',
  `metadata` JSON NULL DEFAULT NULL COMMENT 'Additional metadata (JSON)',
  `is_active` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Whether conversation is active',
  `last_message_at` TIMESTAMP NULL DEFAULT NULL COMMENT 'Timestamp of last message',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  
  CONSTRAINT `fk_conversations_project_id` FOREIGN KEY (`project_id`) 
    REFERENCES `projects` (`id`) ON DELETE CASCADE,
  
  INDEX `idx_type_active` (`type`, `is_active`),
  INDEX `idx_project_active` (`project_id`, `is_active`),
  INDEX `idx_last_message_at` (`last_message_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Conversation Participants table: Users in a conversation
CREATE TABLE `conversation_participants` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `conversation_id` BIGINT UNSIGNED NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `role` ENUM('admin', 'participant') NOT NULL DEFAULT 'participant',
  `joined_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_read_at` TIMESTAMP NULL DEFAULT NULL COMMENT 'Last time user read messages',
  `is_active` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Whether participant is active',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  
  CONSTRAINT `fk_conversation_participants_conversation_id` FOREIGN KEY (`conversation_id`) 
    REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_conversation_participants_user_id` FOREIGN KEY (`user_id`) 
    REFERENCES `users` (`id`) ON DELETE CASCADE,
  UNIQUE KEY `uq_conversation_user` (`conversation_id`, `user_id`),
  
  INDEX `idx_conversation_last_read` (`conversation_id`, `last_read_at`),
  INDEX `idx_user_active` (`user_id`, `is_active`),
  INDEX `idx_last_read_at` (`last_read_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Messages table: Individual messages in conversations
CREATE TABLE `messages` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `conversation_id` BIGINT UNSIGNED NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL COMMENT 'Message sender',
  `body` TEXT NULL DEFAULT NULL COMMENT 'Message content',
  `type` ENUM('text', 'file', 'image', 'system') NOT NULL DEFAULT 'text',
  `attachment` VARCHAR(255) NULL DEFAULT NULL COMMENT 'File/image path or URL',
  `metadata` JSON NULL DEFAULT NULL COMMENT 'Additional metadata (size, mimetype, etc)',
  `deleted_at` TIMESTAMP NULL DEFAULT NULL COMMENT 'Soft delete timestamp',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  
  CONSTRAINT `fk_messages_conversation_id` FOREIGN KEY (`conversation_id`) 
    REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_messages_user_id` FOREIGN KEY (`user_id`) 
    REFERENCES `users` (`id`) ON DELETE CASCADE,
  
  INDEX `idx_conversation_created` (`conversation_id`, `created_at`),
  INDEX `idx_conversation_id` (`conversation_id`, `id`),
  INDEX `idx_user_created` (`user_id`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- NOTIFICATION TABLES
-- ============================================================================

-- User Notifications table: User notifications and alerts
CREATE TABLE `user_notifications` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `type` VARCHAR(50) NOT NULL COMMENT 'Notification type (offer_received, payment_confirmed, etc)',
  `title` VARCHAR(255) NOT NULL COMMENT 'Notification title',
  `message` TEXT NOT NULL COMMENT 'Notification message',
  `data` JSON NULL DEFAULT NULL COMMENT 'Additional data (JSON)',
  `is_read` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Whether notification is read',
  `read_at` TIMESTAMP NULL DEFAULT NULL COMMENT 'When notification was read',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  
  CONSTRAINT `fk_user_notifications_user_id` FOREIGN KEY (`user_id`) 
    REFERENCES `users` (`id`) ON DELETE CASCADE,
  
  INDEX `idx_user_is_read` (`user_id`, `is_read`),
  INDEX `idx_user_created` (`user_id`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- SYSTEM TABLES
-- ============================================================================

-- Failed Jobs table: Queue job failures
CREATE TABLE `failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `connection` VARCHAR(255) NOT NULL COMMENT 'Queue connection name',
  `queue` VARCHAR(255) NOT NULL COMMENT 'Queue name',
  `payload` LONGTEXT NOT NULL COMMENT 'Job payload',
  `exception` LONGTEXT NOT NULL COMMENT 'Exception message',
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  
  INDEX `idx_queue_failed_at` (`queue`, `failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Password Reset Tokens table: Password reset tokens
CREATE TABLE `password_reset_tokens` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) NOT NULL COMMENT 'User email',
  `token` VARCHAR(64) NOT NULL COMMENT 'Reset token',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  
  INDEX `idx_email` (`email`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cache table: Application cache storage
CREATE TABLE `cache` (
  `key` VARCHAR(255) NOT NULL PRIMARY KEY,
  `value` MEDIUMTEXT NOT NULL,
  `expiration` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cache Locks table: Cache lock mechanism
CREATE TABLE `cache_locks` (
  `key` VARCHAR(255) NOT NULL PRIMARY KEY,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Personal Access Tokens table: API authentication tokens
CREATE TABLE `personal_access_tokens` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tokenable_type` VARCHAR(255) NOT NULL COMMENT 'Tokenable model type',
  `tokenable_id` BIGINT UNSIGNED NOT NULL COMMENT 'Tokenable model ID',
  `name` TEXT NOT NULL COMMENT 'Token name',
  `token` VARCHAR(64) NOT NULL UNIQUE COMMENT 'Token value',
  `abilities` TEXT NULL DEFAULT NULL COMMENT 'Token abilities (JSON)',
  `last_used_at` TIMESTAMP NULL DEFAULT NULL COMMENT 'Last used timestamp',
  `expires_at` TIMESTAMP NULL DEFAULT NULL COMMENT 'Token expiration',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  
  INDEX `idx_tokenable` (`tokenable_type`, `tokenable_id`),
  INDEX `idx_expires_at` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- END OF SCHEMA
-- ============================================================================
