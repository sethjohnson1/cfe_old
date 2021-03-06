drop table webpages;
create table webpages(
	id int not null auto_increment,
	primary key(id),
	name varchar(100),
	created datetime,
	modified datetime,
	slug varchar(40),
	visible tinyint(1),
	img varchar(40),
	metatitle varchar(200),
	metadescription varchar(200),
	content text
);

-- the site settings are here
drop table firearms;
create table firearms(
	id int not null auto_increment,
	primary key(id),
	created datetime,
	modified datetime,
	name varchar(255),
	description text,
	setting_value text,
	amount int,
	setting_date_value datetime
	
);

drop table products;
create table products(
	id int not null auto_increment,
	primary key(id),
	created datetime,
	modified datetime,
	prodtype varchar(255), -- either Product or Service depending on API call
	-- no good way to get this yet...
	img varchar(40),
	
	-- direct copy of MINDBODY GetProducts response
	-- this is returned just as 'ID' but uniqueness isn't supported
	barcodeID varchar(255),
	Price float,
	TaxRate float,
	GroupID int,
	Name varchar(255),
	OnlinePrice float,
	ShortDesc text,
	LongDesc text,
	-- color and size return as arrays, skipping until needed
	-- Color varchar(255),
	-- `Size` varchar(255),
	
	-- for convenience, added via Controller
	CategoryID int,
	
	-- this is also used for the Lane as a CSV value of MINDBODY Session IDs, which would be the packages themselves
	CategoryName varchar(255),
	
	ExtendedPrice float,
	-- these are not returned by the Product call but added as a big time saver (or even pure necessity
	SessionTypeID int,
	SessionTypeName varchar(300),
	DoubleTypeID int
);

drop table descriptions;
create table descriptions(
	id int not null auto_increment,
	primary key(id),
	created datetime,
	modified datetime,
	name varchar(255),
	slug varchar(255),
	meta_title varchar(60),
	meta_desc varchar(160),
	description text,
	pagetype varchar(255),
	visible tinyint(1),
	product_id int,
	-- need this to link services back...
	SessionTypeID int
	);

	/** OLD
-- filled in by GetBookableItems, but only when needed very long call
drop table bookdates;
create table bookdates(
	id int not null auto_increment,
	primary key(id),
	created datetime,
	modified datetime,
	bookdate varchar(255)
);

*/

/** OLD
drop table packages;
create table packages(
	id int not null auto_increment,
	primary key(id),
	created datetime,
	modified datetime,
	-- this is returned by API as just 'ID'
	barcodeID int,
	Name varchar(500),
	DiscountPercentage float,
	service_id int,
	product_id int,
	-- to make checkout easier, this is done on Controller
	Price float,
	OnlinePrice float,
	ExtendedPrice float
);


**/
