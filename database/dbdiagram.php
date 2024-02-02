table users {
  id uuid [pk]
  name string
  email string

  email_verified_at timestamp [null]
  password string [null]
  mobile_number string [null]
  profile string [null]
  address string [null]
  active bool
  user_role_id uuid [ref: > roles.id]
  city_id uuid [ref: > cities.id]
  country_id uuid [ref: > countries.id]

  
  created_at timestamp [null]
  updated_at timestamp [null]
}

table roles {
  id uuid [pk]
  role string
  created_at timestamp [null]
  updated_at timestamp [null]
}

table cities {
  id uuid [pk]
  city string
  created_at timestamp [null]
  updated_at timestamp [null]
}

table countries {
  id uuid [pk]
  country string
  created_at timestamp [null]
  updated_at timestamp [null]
}

table notifications {
  id uuid [pk]
  message_id string
  multicast_id string
  user_id uuid [ref: > users.id]
  created_at timestamp [null]
  updated_at timestamp [null]
}

table products {
  id uuid [pk]
  product string
  description longtext
  price string 
  feature_image string
  stock string 
  discount string [null]
  status bool
  
  created_at timestamp [null]
  updated_at timestamp [null]
}

table carts {
  id uuid [pk]
  user_id uuid [ref: > users.id]
  created_at timestamp [null]
  updated_at timestamp [null]
}

table cart_products {
  id uuid [pk]
  quantity string
  cart_id uuid [ref: > carts.id]
  product_id uuid [ref: > products.id]
  created_at timestamp [null]
  updated_at timestamp [null]
}

table methods {
  id uuid [pk]
  method string
  created_at timestamp [null]
  updated_at timestamp [null]
}

table orders {
  id uuid [pk]
  quantity string
  cart_product_id uuid [ref: > cart_products.id]
  method_id uuid [ref: > methods.id]
  city_id uuid [ref: > cities.id]
  created_at timestamp [null]
  updated_at timestamp [null]
}

table categories {
  id uuid [pk]
  category string
  created_at timestamp [null]
  updated_at timestamp [null]
}

table  category_products{
  id uuid [pk]
  product_id uuid [ref: > products.id]
  category_id uuid [ref: > categories.id]
  created_at timestamp [null]
  updated_at timestamp [null]
}



















