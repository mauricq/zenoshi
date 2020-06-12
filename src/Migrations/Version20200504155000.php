<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200504155000 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     11/6/2020 18:12:49                           */
/*==============================================================*/

/* drop database test02;*/

/* create database test02;*/

/* use test02;*/

drop table if exists TRANSACTION;

drop table if exists ACCOUNT;

drop table if exists PICTUREPOOL;

drop table if exists RECEIP;

drop table if exists PRODUCT;

drop table if exists MERCHANT;

drop table if exists PINCODE;

drop table if exists SOCIALNETWORK;

drop table if exists USER_HAS_PROFILE;

drop table if exists USER;

drop table if exists PERSON;

drop table if exists FILE;

drop table if exists MENU;

drop table if exists PROFILE_MODULE;

drop table if exists MODULE;

drop table if exists PROFILE;

drop table if exists REWARD;

drop table if exists CATALOGUE;

/*==============================================================*/
/* Table: CATALOGUE                                             */
/*==============================================================*/
create table CATALOGUE
(
   ID_CATALOG           int not null AUTO_INCREMENT,
   ID_PARENT            int,
   STATUS               varchar(10) not null,
   TYPE                 varchar(100) not null,
   NAME                 varchar(200) not null,
   DESCRIPTION          varchar(200) not null,
   primary key (ID_CATALOG),
   constraint FK_PARENT foreign key (ID_PARENT)
      references CATALOGUE (ID_CATALOG) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: FILE                                                  */
/*==============================================================*/
create table FILE
(
   ID_FILE              int not null AUTO_INCREMENT,
   FILE_NAME            varchar(100) not null,
   FILE_LOCATION        varchar(200) not null,
   FILE_REAL_NAME       varchar(200) not null,
   SIZE                 int,
   CREATION_DATE        datetime not null,
   STATUS               varchar(10),
   primary key (ID_FILE)
);

/*==============================================================*/
/* Table: PERSON                                                */
/*==============================================================*/
create table PERSON
(
   ID_PERSON            int not null AUTO_INCREMENT,
   ID_PERSON_STATUS     int,
   ID_PERSON_PICTURE    int,
   ID_CLIENT_LOCATION   int,
   NAME                 varchar(200) not null,
   LAST_NAME            varchar(100) not null,
   IDENTIFICATION_TYPE  varchar(50),
   IDENTIFICATION_NUMBER varchar(20),
   BIRTH_DATE           date,
   MOBILE               varchar(20) not null,
   ADDRESS              varchar(200),
   primary key (ID_PERSON),
   constraint FK_CLIENT_LOCATION foreign key (ID_CLIENT_LOCATION)
      references CATALOGUE (ID_CATALOG) on delete restrict on update restrict,
   constraint FK_PERSON_PICTURE foreign key (ID_PERSON_PICTURE)
      references FILE (ID_FILE) on delete restrict on update restrict,
   constraint FK_PERSON_STATUS foreign key (ID_PERSON_STATUS)
      references CATALOGUE (ID_CATALOG) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: ACCOUNT                                               */
/*==============================================================*/
create table ACCOUNT
(
   ID_ACCOUNT           int not null AUTO_INCREMENT,
   ID_PERSON            int,
   ACCOUNT_NUMBER       varchar(20) not null,
   TOTAL_INCENTIVE_POINTS int,
   REWARD_COINS         int,
   LAST_UPDATE          datetime,
   primary key (ID_ACCOUNT),
   constraint FK_PERSON_ACCOUNT foreign key (ID_PERSON)
      references PERSON (ID_PERSON) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: MODULE                                                */
/*==============================================================*/
create table MODULE
(
   ID_MODULE            int not null AUTO_INCREMENT,
   ID_SUBMODULE         int,
   ID_MODULE_STATUS     int,
   MODULE_CODE          varchar(50) not null,
   MODULE_NAME          varchar(50) not null,
   primary key (ID_MODULE),
   constraint FK_SUBMODULO foreign key (ID_SUBMODULE)
      references MODULE (ID_MODULE) on delete restrict on update restrict,
   constraint FK_MODULE_STATUS foreign key (ID_MODULE_STATUS)
      references CATALOGUE (ID_CATALOG) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: MENU                                                  */
/*==============================================================*/
create table MENU
(
   ID_MENU              int not null AUTO_INCREMENT,
   ID_MODULE            int,
   ID_MENU_STATUS       int,
   MENU_CODE            varchar(50) not null,
   MENU_NAME            varchar(50) not null,
   MENU_LINK            varchar(200) not null,
   primary key (ID_MENU),
   constraint FK_CORRESPOND foreign key (ID_MODULE)
      references MODULE (ID_MODULE) on delete restrict on update restrict,
   constraint FK_MENU_STATUS foreign key (ID_MENU_STATUS)
      references CATALOGUE (ID_CATALOG) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: MERCHANT                                              */
/*==============================================================*/
create table MERCHANT
(
   ID_MERCHANT          int not null AUTO_INCREMENT,
   ID_CATALOG           int,
   ID_MERCHANT_CATEGORY int,
   CAT_ID_CATALOG2      int,
   ID_PERSON            int,
   MERCHANT_NAME        varchar(200),
   ADDRESS              varchar(200),
   POINTS               int,
   CITY                 varchar(100),
   COUNTRY              varchar(100),
   WEBSITE              varchar(999),
   APPROVAL_DATE        datetime,
   REGISTRATION_DATE    datetime not null,
   primary key (ID_MERCHANT),
   constraint FK_MERCHANT_OWNER_PERSON foreign key (ID_PERSON)
      references PERSON (ID_PERSON) on delete restrict on update restrict,
   constraint FK_STATUS_APPROVAL foreign key (CAT_ID_CATALOG2)
      references CATALOGUE (ID_CATALOG) on delete restrict on update restrict,
   constraint FK_STATUS_MERCHANT foreign key (ID_CATALOG)
      references CATALOGUE (ID_CATALOG) on delete restrict on update restrict,
   constraint FK_MERCHANT_CATEGORY foreign key (ID_MERCHANT_CATEGORY)
      references CATALOGUE (ID_CATALOG) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: RECEIP                                                */
/*==============================================================*/
create table RECEIP
(
   ID_RECEIP            int not null AUTO_INCREMENT,
   ID_PERSON_UPLOAD_RECEIP int,
   ID_MERCHANT          int,
   ID_CATALOG           int,
   MERCHANT_NAME        varchar(200) not null,
   AMOUNT               decimal not null,
   DATE_EMISSION        datetime not null,
   DATE_REGISTRATION    datetime not null,
   INCENTIVE_POINTS     int,
   primary key (ID_RECEIP),
   constraint FK_RECEIP_MERCHANT foreign key (ID_MERCHANT)
      references MERCHANT (ID_MERCHANT) on delete restrict on update restrict,
   constraint FK_PERSON_UPLOAD_RECEIP foreign key (ID_PERSON_UPLOAD_RECEIP)
      references PERSON (ID_PERSON) on delete restrict on update restrict,
   constraint FK_RECEIP_APPROBATION foreign key (ID_CATALOG)
      references CATALOGUE (ID_CATALOG) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: PICTUREPOOL                                           */
/*==============================================================*/
create table PICTUREPOOL
(
   ID_PICTURE_POOL      int not null AUTO_INCREMENT,
   ID_RECEIP            int,
   ID_FILE              int,
   CREATION_DATE        datetime not null,
   primary key (ID_PICTURE_POOL),
   constraint FK_RECEIP_PICTURE_POOL foreign key (ID_RECEIP)
      references RECEIP (ID_RECEIP) on delete restrict on update restrict,
   constraint FK_PICTURE_POOL_FILES foreign key (ID_FILE)
      references FILE (ID_FILE) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: PINCODE                                               */
/*==============================================================*/
create table PINCODE
(
   ID_PINCODE           int not null AUTO_INCREMENT,
   ID_CATALOG           int,
   ID_PERSON            int,
   PLASTIC_BRAND        varchar(25),
   NAME_DISPLAYED       varchar(200) not null,
   PIN_CODE             varchar(16) not null,
   STATUS               varchar(10),
   CITY                 varchar(100),
   COUNTRY              varchar(100),
   CONTINENT            varchar(20),
   EXPIRATION_DATE      varchar(5),
   primary key (ID_PINCODE),
   constraint FK_PERSON_PINCODES foreign key (ID_PERSON)
      references PERSON (ID_PERSON) on delete restrict on update restrict,
   constraint FK_PIN_STATUS foreign key (ID_CATALOG)
      references CATALOGUE (ID_CATALOG) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: PRODUCT                                               */
/*==============================================================*/
create table PRODUCT
(
   ID_PRODUCT           int not null AUTO_INCREMENT,
   ID_MERCHANT          int,
   ID_CATALOG           int,
   ID_PHOTO_PRODUCT     int,
   NAME                 varchar(200) not null,
   DESCRIPTION          varchar(200) not null,
   DISCOUNT             decimal,
   POINTS               int,
   primary key (ID_PRODUCT),
   constraint FK_MERCHANT_PRODUCT foreign key (ID_MERCHANT)
      references MERCHANT (ID_MERCHANT) on delete restrict on update restrict,
   constraint FK_PRODUCT_STATUS foreign key (ID_CATALOG)
      references CATALOGUE (ID_CATALOG) on delete restrict on update restrict,
   constraint FK_PHOTO_PRODUCT foreign key (ID_PHOTO_PRODUCT)
      references FILE (ID_FILE) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: PROFILE                                               */
/*==============================================================*/
create table PROFILE
(
   ID_PROFILE           int not null AUTO_INCREMENT,
   ID_CATALOG           int,
   PROFILE_CODE         varchar(50) not null,
   PROFILE_NAME         varchar(50) not null,
   primary key (ID_PROFILE),
   constraint FK_PROFILE_STATUS foreign key (ID_CATALOG)
      references CATALOGUE (ID_CATALOG) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: PROFILE_MODULE                                        */
/*==============================================================*/
create table PROFILE_MODULE
(
   ID_PROFILE           int not null AUTO_INCREMENT,
   ID_MODULE            int not null,
   primary key (ID_PROFILE, ID_MODULE),
   constraint FK_PROFILE_MODULE foreign key (ID_PROFILE)
      references PROFILE (ID_PROFILE) on delete restrict on update restrict,
   constraint FK_PROFILE_MODULE2 foreign key (ID_MODULE)
      references MODULE (ID_MODULE) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: REWARD                                                */
/*==============================================================*/
create table REWARD
(
   ID_REWARD            int not null AUTO_INCREMENT,
   ID_CATALOG           int,
   NAME_REWARD          varchar(100) not null,
   DESCRIPTION_REWARD   varchar(999),
   RULE_REWARD          varchar(9999),
   INCENTIVE_POINTS     int,
   primary key (ID_REWARD),
   constraint FK_REWARD_STATUS foreign key (ID_CATALOG)
      references CATALOGUE (ID_CATALOG) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: USER                                                  */
/*==============================================================*/
create table USER
(
   ID_USER              int not null AUTO_INCREMENT,
   ID_PERSON            int,
   ID_CATALOG           int,
   USERNAME             varchar(255),
   PASSWORD             varchar(255),
   PLAINPASSWORD        varchar(255),
   UNIQUE_ID            varchar(200) not null,
   EMAIL                varchar(100) not null,
   SALT                 varchar(50),
   ROLES                varchar(100),
   APP_KEY              varchar(191),
   CREATED_AT           datetime,
   UPDATED_AT           datetime,
   primary key (ID_USER),
   constraint FK_PERSON_USER foreign key (ID_PERSON)
      references PERSON (ID_PERSON) on delete restrict on update restrict,
   constraint FK_USER_STATUS foreign key (ID_CATALOG)
      references CATALOGUE (ID_CATALOG) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: SOCIALNETWORK                                         */
/*==============================================================*/
create table SOCIALNETWORK
(
   ID_SOCIAL_NETWORK    int not null AUTO_INCREMENT,
   ID_USER              int,
   NETWORK              varchar(200) not null,
   ID_NETWORK           varchar(200) not null,
   STATUS               varchar(10) not null,
   OBSERVATION          varchar(200),
   primary key (ID_SOCIAL_NETWORK),
   constraint FK_USER_SOCIALNETWORK foreign key (ID_USER)
      references USER (ID_USER) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: TRANSACTION                                           */
/*==============================================================*/
create table TRANSACTION
(
   ID_TRANSACTION       int not null AUTO_INCREMENT,
   ID_ACCOUNT           int not null,
   ID_TRANSACTION_TYPE  int not null,
   DATE_TRANSACTION     datetime not null,
   POINTS               int not null,
   DEBIT_CREDIT         char(1) not null,
   DESCRIPTION          varchar(200),
   primary key (ID_TRANSACTION),
   constraint FK_TRANSACTION_TYPE foreign key (ID_TRANSACTION_TYPE)
      references CATALOGUE (ID_CATALOG) on delete restrict on update restrict,
   constraint FK_ACCOUNT_TRANSACTION foreign key (ID_ACCOUNT)
      references ACCOUNT (ID_ACCOUNT) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: USER_HAS_PROFILE                                      */
/*==============================================================*/
create table USER_HAS_PROFILE
(
   ID_USER              int not null AUTO_INCREMENT,
   ID_PROFILE           int not null,
   primary key (ID_USER, ID_PROFILE),
   constraint FK_USER_HAS_PROFILE foreign key (ID_USER)
      references USER (ID_USER) on delete restrict on update restrict,
   constraint FK_USER_HAS_PROFILE2 foreign key (ID_PROFILE)
      references PROFILE (ID_PROFILE) on delete restrict on update restrict
);


        ');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
drop table if exists CATALOGUE;

drop table if exists CLIENT;

drop table if exists COURIER;

drop table if exists FILE;

-- drop index CORRESPOND2_FK on MENU;

drop table if exists MENU;

drop table if exists MODULE;

drop table if exists ORDERDETAIL;

drop table if exists ORDERPAYMENT;

drop table if exists PERSON;

drop table if exists PRODUCT;

drop table if exists PROFILE;

drop table if exists PROFILE_MODULE;

drop table if exists PURCHASEORDER;

drop table if exists ROL;

drop table if exists SALER;

drop table if exists SHIPPING;

drop table if exists USER;

drop table if exists USER_HAS_PROFILES;

drop table if exists USER_HAS_ROLS;

        ');
    }
}
