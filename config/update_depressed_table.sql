-- Add new columns to depressed table
ALTER TABLE depressed 
ADD COLUMN priority ENUM('High', 'Medium') NOT NULL DEFAULT 'High',
ADD COLUMN score INT NOT NULL,
ADD COLUMN status ENUM('Pending', 'In Progress', 'Completed') NOT NULL DEFAULT 'Pending';

-- Update existing records
UPDATE depressed SET priority = 'High', status = 'Pending' WHERE priority IS NULL;
