CREATE TABLE container (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    item_id INT NOT NULL,
    base_container_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
