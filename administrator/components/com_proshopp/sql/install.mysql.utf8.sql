CREATE TABLE `#__shopp_Stock` (

`id` int(10) NOT NULL,

`state` int(2) NULL,

`low_count` smallint(3) NULL,

`critical_count` smallint(2) NULL,

`name` varchar(255) NULL,

PRIMARY KEY (`id`) 

);



CREATE TABLE `#__shopp_Service` (

`id` int NOT NULL,

`state` int(2) NULL,

`name` varchar(255) NULL,

`description` char(255) NULL,

PRIMARY KEY (`id`) 

);



CREATE TABLE `#__shopp_Service_variats` (

`id` int NOT NULL,

`service_id` int NULL,

`name` varchar(255) NULL,

`price` decimal(10,2) NULL,

`currency` varchar(4) NULL,

`sort` varchar(10) NULL,

PRIMARY KEY (`id`) 

);



CREATE TABLE `#__shopp_Type` (

`id` int NOT NULL,

`state` int(2) NULL,

`sort` int(2) NULL,

`name` varchar(255) NULL,

`icon` varchar(255) NULL,

`themp` text NULL,

PRIMARY KEY (`id`) 

);



CREATE TABLE `#__shopp_Type_Service` (

`type_id` int NOT NULL,

`service_id` int NOT NULL

);



CREATE TABLE `#__shopp_feature` (

`id` int NOT NULL,

`state` int(2) NULL,

`name` varchar(255) NULL,

`code` varchar(255) NULL,

`type` varchar(255) NULL,

PRIMARY KEY (`id`) 

);



CREATE TABLE `#__shopp_feature_value` (

`id` int(10) NOT NULL,

`state` int(2) NULL,

`feature_id` int(10) NULL,

`title` varchar(255) NULL,

`value` varchar(255) NULL,

PRIMARY KEY (`id`) 

);



CREATE TABLE `#__shopp_type_feature` (

`type_id` int(10) NULL,

`feature_id` int(10) NULL,

`sort` int(100) NULL

);



CREATE TABLE `#__shopp_set` (

`id` varchar(255) NULL,

`name` varchar(255) NULL,

`rule` varchar(50) NULL,

`type` int(1) NULL,

`count` int(11) NULL

);



CREATE TABLE `#__shopp_set_product` (

`set_id` varchar(255) NULL,

`product_id` int(10) NULL

);



CREATE TABLE `#__shopp_product` (

`id` int(11) NOT NULL,

`name` varchar(255) NULL,

`summary` text NULL,

`meta_title` varchar(255) NULL,

`meta_keywords` varchar(255) NULL,

`meta_description` varchar(255) NULL,

`description` text NULL,

`state` int(2) NULL,

`category_id` int(10) NULL,

`badge` varchar(255) NULL,

`default_pic` varchar(255) NULL,

`gallery` varchar(255) NULL,

PRIMARY KEY (`id`) 

);



CREATE TABLE `#__shopp_product_feature` (

`id` int(10) NOT NULL,

`product_id` int(10) NULL,

`sku_id` int(10) NULL,

`feature_id` int(10) NULL,

`feature_value` varchar(255) NULL,

PRIMARY KEY (`id`) 

);



CREATE TABLE `#__shopp_product_sku` (

`id` int(10) NULL,

`product_id` int(10) NULL,

`sku` varchar(255) NULL,

`sort` int(11) NULL,

`name` varchar(255) NULL,

`image` varchar(255) NULL,

`price` decimal(10,2) NULL,

`off_price` decimal(10,2) NULL,

`compare_price` decimal(10,2) NULL

);



CREATE TABLE `#__shopp_product_service` (

`id` int(10) NOT NULL,

`product_id` int(10) NULL,

`sku_id` int(10) NULL,

`service_id` int(10) NULL,

`service_variant_id` int(10) NULL,

`price` decimal(10,2) NULL,

PRIMARY KEY (`id`) 

);



CREATE TABLE `#__shopp_product_stock` (

`suk_id` int(10) NULL,

`stock_id` int(10) NULL,

`product_id` int(10) NULL,

`count` int(10) NULL

);



CREATE TABLE `#__shopp_stock_log` (

`id` int(10) NOT NULL,

`product_id` int(10) NULL,

`sku_id` int(10) NULL,

`befor_count` int(11) NULL,

`after_count` int(11) NULL,

`type` varchar(50) NULL,

`datetime` datetime NULL,

`order_id` int(10) NULL,

PRIMARY KEY (`id`) 

);



CREATE TABLE `#__shopp_order` (

`id` int(10) NOT NULL,

`user_id` int(10) NULL,

`create_datetime` datetime NULL,

`update_datetime` datetime NULL,

`state` varchar(255) NULL,

`shipping` varchar(255) NULL,

`tax` varchar(255) NULL,

`paid_data` date NULL,

`comment` text NULL,

`user_ip` varchar(255) NULL,

`coupon_code` varchar(150) NULL,

PRIMARY KEY (`id`) 

);



CREATE TABLE `#__shopp_order_items` (

`id` int(10) NOT NULL,

`order_id` int(10) NULL,

`name` varchar(255) NULL,

`product_id` int(10) NULL,

`sku_id` int(10) NULL,

`service_id` int(10) NULL,

`type` varchar(255) NULL,

`service_variant_id` varchar(255) NULL DEFAULT NULL,

`price` decimal(10,2) NULL,

`quantity` int(3) NULL,

`parent_id` int(10) NULL,

`stock_id` int(10) NULL,

`discount` decimal(10,2) NULL,

`payment` decimal(10,2) NULL,

PRIMARY KEY (`id`) 

);



CREATE TABLE `#__shopp_order_log` (

`id` int(10) NULL,

`order_id` int(10) NULL,

`user_id` int(10) NULL,

`action` varchar(50) NULL,

`datetime` datetime NULL,

`text` text NULL

);



CREATE TABLE `#__shopp_cart_items` (

`id` int(10) NOT NULL,

`code` varchar(50) NULL,

`user_id` int(10) NULL,

`product_id` int(10) NULL,

`sku_id` int(10) NULL,

`create_datetime` datetime NULL,

`quantity` int(5) NULL,

`type` varchar(255) NULL,

`service_id` int(10) NULL,

`service_variant_id` int(10) NULL,

`parent_id` int(10) NULL,

PRIMARY KEY (`id`) 

);

