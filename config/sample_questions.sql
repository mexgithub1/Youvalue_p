-- Sample base questions (Normal assessment - first time takers)
INSERT INTO questionnaires (questions, choice1, choice2, choice3, choice4, answers, category) VALUES
('How often do you feel overwhelmed by daily tasks?', 'Never', 'Sometimes', 'Often', 'Always', 'Never', 'normal'),
('How would you rate your sleep quality?', 'Excellent', 'Good', 'Fair', 'Poor', 'Excellent', 'normal'),
('How often do you feel energetic throughout the day?', 'Always', 'Often', 'Sometimes', 'Never', 'Always', 'normal'),
('How would you describe your social interactions?', 'Very Active', 'Moderately Active', 'Somewhat Limited', 'Very Limited', 'Very Active', 'normal'),
('How do you handle stress?', 'Very Well', 'Well', 'With Difficulty', 'Poorly', 'Very Well', 'normal');

-- Sample Normal Level 2 Questions (for those who were previously normal)
INSERT INTO questionnaires_normal_2 (questions, choice1, choice2, choice3, choice4, answers) VALUES
('How satisfied are you with your daily routine?', 'Very Satisfied', 'Satisfied', 'Somewhat Satisfied', 'Not Satisfied', 'Very Satisfied'),
('How often do you engage in activities you enjoy?', 'Daily', 'Few times a week', 'Once a week', 'Rarely', 'Daily'),
('Rate your ability to maintain work-life balance:', 'Excellent', 'Good', 'Fair', 'Poor', 'Excellent'),
('How often do you practice self-care?', 'Regularly', 'Sometimes', 'Rarely', 'Never', 'Regularly'),
('How would you rate your current stress management?', 'Very Effective', 'Effective', 'Somewhat Effective', 'Not Effective', 'Very Effective');

-- Sample Anxiety Level 2 Questions (for those who showed anxiety symptoms)
INSERT INTO questionnaires_anxiety_2 (questions, choice1, choice2, choice3, choice4, answers) VALUES
('How often do you experience physical symptoms of anxiety?', 'Never', 'Sometimes', 'Often', 'Very Often', 'Never'),
('When anxious, what coping strategies do you use?', 'Multiple strategies', 'Few strategies', 'One strategy', 'No strategies', 'Multiple strategies'),
('How does anxiety affect your daily activities?', 'No effect', 'Minor effect', 'Moderate effect', 'Severe effect', 'No effect'),
('Do you avoid situations due to anxiety?', 'Never', 'Rarely', 'Sometimes', 'Often', 'Never'),
('How well can you identify anxiety triggers?', 'Very well', 'Somewhat', 'Not very well', 'Not at all', 'Very well');

-- Sample Depression Level 2 Questions (for those who showed depression symptoms)
INSERT INTO questionnaires_depression_2 (questions, choice1, choice2, choice3, choice4, answers) VALUES
('How is your appetite compared to usual?', 'Normal', 'Slightly changed', 'Moderately changed', 'Severely changed', 'Normal'),
('How often do you feel hopeful about the future?', 'Always', 'Often', 'Sometimes', 'Rarely', 'Always'),
('How is your concentration level?', 'Excellent', 'Good', 'Fair', 'Poor', 'Excellent'),
('How often do you engage in activities you used to enjoy?', 'Frequently', 'Sometimes', 'Rarely', 'Never', 'Frequently'),
('How would you rate your energy levels?', 'High', 'Moderate', 'Low', 'Very Low', 'High');

-- Update existing questions in questionnaires table with categories
UPDATE questionnaires SET category = 'anxiety' WHERE 
    questions LIKE '%anxious%' OR 
    questions LIKE '%worry%' OR 
    questions LIKE '%nervous%';

UPDATE questionnaires SET category = 'depression' WHERE 
    questions LIKE '%sad%' OR 
    questions LIKE '%hopeless%' OR 
    questions LIKE '%depressed%';
