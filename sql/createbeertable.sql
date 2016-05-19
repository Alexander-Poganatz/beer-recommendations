--File author: Alexander Poganatz
CREATE TABLE Beer
(
  beer_id INT NOT NULL AUTO_INCREMENT,
  beer_brand_name VARCHAR(50) NOT NULL,
  beer_type_id INT,
  recommendation_id INT,
  PRIMARY KEY(beer_id),
  FOREIGN KEY(beer_type_id) REFERENCES Beer_Type(beer_type_id),
  FOREIGN KEY(recommendation_id) REFERENCES Recommendation(recommendation_id)
);
