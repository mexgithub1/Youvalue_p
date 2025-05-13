-- Create table for normal level 2 questions
CREATE TABLE questionnaires_normal_2 (
    id INT PRIMARY KEY AUTO_INCREMENT,
    questions TEXT NOT NULL,
    choice1 TEXT NOT NULL,
    choice2 TEXT NOT NULL,
    choice3 TEXT NOT NULL,
    choice4 TEXT NOT NULL,
    answers TEXT NOT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create table for anxiety level 2 questions
CREATE TABLE questionnaires_anxiety_2 (
    id INT PRIMARY KEY AUTO_INCREMENT,
    questions TEXT NOT NULL,
    choice1 TEXT NOT NULL,
    choice2 TEXT NOT NULL,
    choice3 TEXT NOT NULL,
    choice4 TEXT NOT NULL,
    answers TEXT NOT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create table for depression level 2 questions
CREATE TABLE questionnaires_depression_2 (
    id INT PRIMARY KEY AUTO_INCREMENT,
    questions TEXT NOT NULL,
    choice1 TEXT NOT NULL,
    choice2 TEXT NOT NULL,
    choice3 TEXT NOT NULL,
    choice4 TEXT NOT NULL,
    answers TEXT NOT NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add category column to original questionnaires table if not exists
ALTER TABLE questionnaires ADD COLUMN category ENUM('normal', 'anxiety', 'depression') DEFAULT 'normal';

-- Create table to track user's last assessment category
CREATE TABLE user_assessment_history (
    id INT PRIMARY KEY AUTO_INCREMENT,
    users_id INT NOT NULL,
    last_category ENUM('normal', 'anxiety', 'depression') NOT NULL,
    assessment_date DATE NOT NULL,
    FOREIGN KEY (users_id) REFERENCES users(id)
);
