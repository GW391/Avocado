<?php

if (!isset($DataBaseName)){
$DataBaseName = $DatabaseName;
}


// Create Calendar Table

  $sql_pcalder="CREATE TABLE IF NOT EXISTS $DataBaseName.Pcalder(
  UID bigint(20) NOT NULL AUTO_INCREMENT,
  Date date NOT NULL,
  Event text NOT NULL,
  venue text NOT NULL,
  Time time NOT NULL,
  datecreted date NOT NULL,
  whocreated text NOT NULL,
  dateupdated date DEFAULT NULL,
  whoupdated text,
  target text,
  section text,
  subsection text,
  Deleted tinyint(1) DEFAULT '0',
  ETime time DEFAULT NULL,
  flyers varchar(150) DEFAULT NULL,
  Restricted tinyint(1) unsigned zerofill DEFAULT '0',
  thumbnail text DEFAULT NULL,
  seriesID bigint(20),
  PRIMARY KEY (UID),
  KEY Date (Date),
  KEY Time (Time),
  KEY `Date & Time` (Date, Time),
  KEY (seriesID)
)";
  
  mysqli_query($con, $sql_pcalder);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Caledar Table Crated <br />";
}

// Create Settings Table
$sql_tblsettings="CREATE TABLE IF NOT EXISTS $DataBaseName.tblsettings(
    UUID bigint(20) NOT NULL AUTO_INCREMENT,
    Name varchar(45) NOT NULL,
    Value longtext DEFAULT NULL,
    whocreate varchar(45) DEFAULT NULL,
    updated date DEFAULT NULL,
    whoupdate varchar(45) DEFAULT NULL,
    Deleted tinyint(1) NOT NULL DEFAULT '0',
    num_rows varchar(3) NOT NULL DEFAULT '1',
    cols int(3) NOT NULL DEFAULT '50',
    help longtext,
    Options varchar(1000),
    Grouping varchar(250) NOT NULL,
    PRIMARY KEY (UUID),
    KEY Name (Name),
    KEY `group` (Grouping)
)";

  mysqli_query($con, $sql_tblsettings);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Settings Table Crated <br />";
}
 // Create Content Table

 $sql_tblcontent="CREATE TABLE IF NOT EXISTS $DataBaseName.tblcontent (
  UUID bigint(20) NOT NULL AUTO_INCREMENT,
  menuid bigint(20) DEFAULT NULL,
  target varchar(45) NOT NULL,
  section varchar(45) DEFAULT NULL,
  subsection varchar(45) DEFAULT NULL,
  security varchar(45) DEFAULT NULL,
  format varchar(4) NOT NULL,
  active tinyint(1) NOT NULL DEFAULT '0',
  header varchar(256) DEFAULT NULL,
  page longtext CHARACTER SET utf8 DEFAULT NULL,
  CDate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  SDate date NOT NULL,
  FDate date NOT NULL,
  Deleted tinyint(1) NOT NULL DEFAULT '0',
  sortorder varchar(45) DEFAULT NULL,
  System VARCHAR(45) DEFAULT NULL,
  PRIMARY KEY (UUID)
)";

  mysqli_query($con, $sql_tblcontent);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Content Table Crated <br />";
}

// Create Menu Table
$sql_tblMenu="CREATE TABLE IF NOT EXISTS $DataBaseName.tblmenu (
  UUID bigint(20) NOT NULL AUTO_INCREMENT,
  target varchar(45) NOT NULL,
  section varchar(45) DEFAULT NULL,
  subsection varchar(45) DEFAULT NULL,
  security varchar(45) DEFAULT NULL,
  sortorder int(5) DEFAULT NULL,
  CDate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  Deleted tinyint(1) NOT NULL DEFAULT '0',
  Articles int(11) NOT NULL DEFAULT '1',
  History tinyint(4) NOT NULL DEFAULT '0',
  TLD tinyint(1) DEFAULT NULL,
  DispName varchar(45) DEFAULT NULL,
  whoupdate varchar(45) DEFAULT NULL,
  UDate date DEFAULT NULL,
  System tinyint(1) unsigned zerofill NOT NULL DEFAULT '0',
  WhoCreate varchar(45) NOT NULL,
  DateCreate date NOT NULL,
  ShortArticle tinyint(1) NOT NULL DEFAULT '0',
  PublicPost tinyint(1) NOT NULL DEFAULT '0',
  ContName varchar(45) DEFAULT NULL,
  Extra varchar(45) DEFAULT NULL,
  sitemap tinyint(1) NOT NULL DEFAULT '1',
  notloggedin varchar(45) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT '0',
  PRIMARY KEY (UUID)
  )";
          
mysqli_query($con, $sql_tblMenu);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Menu Table Crated <br />";
}


// Create Users Table
$sql_tblUsers="CREATE TABLE IF NOT EXISTS $DataBaseName.tblpdu (
  UUID bigint(20) NOT NULL AUTO_INCREMENT,
  PUME varchar(500) NOT NULL,
  PRD varchar(500) NOT NULL,
  PRNME varchar(50) NOT NULL,
  PEL varchar(255) NOT NULL,
  PSY varchar(500) NOT NULL,
  PVD tinyint(1) NOT NULL DEFAULT '0',
  PRDate date DEFAULT NULL,
  PLLDate datetime DEFAULT NULL,
  PLCDate date DEFAULT NULL,
  Deleted tinyint(1) NOT NULL DEFAULT '0',
  whoupdate varchar(50) DEFAULT NULL,
  PUDate date DEFAULT NULL,
  tblpduData tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (UUID),
  UNIQUE KEY UNAME (PUME)
)";

mysqli_query($con, $sql_tblUsers);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Users Table Crated <br />";
}

$sql_tblnewsletter = "CREATE TABLE IF NOT EXISTS $DataBaseName.tblnewsletter (
  idtblnewsletter bigint(11) NOT NULL AUTO_INCREMENT,
  Email varchar(255) DEFAULT NULL,
  RName varchar(500) DEFAULT NULL,
  PVD tinyint(1) DEFAULT NULL,
  data tinyint(1) DEFAULT NULL,
  Deleted tinyint(1) NOT NULL DEFAULT '0',
  fails VARCHAR(45) NULL DEFAULT 0,
  Test tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idtblnewsletter`)
)";

mysqli_query($con, $sql_tblnewsletter);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "News Letter Subscriber list Table Crated <br />";
}

// Create Error Log Table
$sql_tblErrorLog="CREATE TABLE IF NOT EXISTS $DataBaseName.tblelg (
  idtblelg int(10) unsigned NOT NULL AUTO_INCREMENT,
  uname varchar(45) DEFAULT NULL,
  pword varchar(45) DEFAULT NULL,
  err varchar(500) NOT NULL,
  date datetime NOT NULL,
  IPAdd varchar(45) NOT NULL,
  target varchar(145) DEFAULT NULL,
  section varchar(145) DEFAULT NULL,
  subsection varchar(145) DEFAULT NULL,
  referer varchar(145) DEFAULT NULL,
  PRIMARY KEY (idtblelg)
)";

mysqli_query($con, $sql_tblErrorLog);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Error Log Table Crated <br />";
}

// Create Attachemnts table
$sql_tblattachment="CREATE TABLE IF NOT EXISTS $DataBaseName.tblattachment (
  UUID int(10) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(250) DEFAULT NULL,
  type varchar(45) DEFAULT NULL,
  size float(50) NOT NULL,
  file_name varchar(45) DEFAULT NULL,
  file_type varchar(45) DEFAULT NULL,
  duration varchar(45) DEFAULT NULL,
  Meta_1 varchar(250) DEFAULT NULL,
  Meta_2 varchar(250) DEFAULT NULL,
  Meta_3 varchar(250) DEFAULT NULL,
  Meta_4 varchar(250) DEFAULT NULL,
  Description text DEFAULT NULL,
  WhoCreate varchar(45) NOT NULL,
  DateCreate date NOT NULL,
  WhoUpdate varchar(45) DEFAULT NULL,
  DateUpdate date  DEFAULT NULL,
  Date date DEFAULT NULL,
  FileTime varchar(15) DEFAULT NULL,
  deleted binary(1) DEFAULT 0,
  PRIMARY KEY (UUID),
  KEY Date (Date),
  KEY name (name)
)";

mysqli_query($con, $sql_tblattachment);
      if (!$con) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}else{
    echo "Attachment Table Crated <br />";
}
?>
