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
/* Created on:     18/6/2020 3:13:46                            */
/*==============================================================*/


/*        drop database az8lyu5njajf84ao;         */

/*        create database az8lyu5njajf84ao;       */

/*        use az8lyu5njajf84ao;                   */

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
/* Table: catalogue                                             */
/*==============================================================*/
create table catalogue
(
   id_catalog           int not null AUTO_INCREMENT,
   cat_id_catalog       int,
   status               varchar(10) not null,
   icon                 varchar(100),
   type                 varchar(100) not null,
   name                 varchar(200) not null,
   description          varchar(200) not null,
   primary key (id_catalog),
   constraint fk_parent foreign key (cat_id_catalog)
      references catalogue (id_catalog) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: file                                                  */
/*==============================================================*/
create table file
(
   id_file              int not null AUTO_INCREMENT,
   file_name            varchar(100) not null,
   file_location        varchar(200) not null,
   file_real_name       varchar(200) not null,
   size                 int,
   creation_date        datetime not null,
   status               varchar(10),
   primary key (id_file)
);

/*==============================================================*/
/* Table: person                                                */
/*==============================================================*/
create table person
(
   id_person            int not null AUTO_INCREMENT,
   id_catalog           int,
   id_file              int,
   cat_id_catalog       int,
   name                 varchar(200) not null,
   last_name            varchar(100) not null,
   identification_type  varchar(50),
   identification_number varchar(20),
   birth_date           date,
   mobile               varchar(20) not null,
   address              varchar(200),
   primary key (id_person),
   constraint fk_client_location foreign key (cat_id_catalog)
      references catalogue (id_catalog) on delete restrict on update restrict,
   constraint fk_person_picture foreign key (id_file)
      references file (id_file) on delete restrict on update restrict,
   constraint fk_person_status foreign key (id_catalog)
      references catalogue (id_catalog) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: account                                               */
/*==============================================================*/
create table account
(
   id_account           int not null AUTO_INCREMENT,
   id_person            int,
   account_number       varchar(20) not null,
   total_incentive_points int,
   reward_coins         int,
   last_update          datetime,
   primary key (id_account),
   constraint fk_person_account foreign key (id_person)
      references person (id_person) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: module                                                */
/*==============================================================*/
create table module
(
   id_module            int not null AUTO_INCREMENT,
   mod_id_module        int,
   id_catalog           int,
   module_code          varchar(50) not null,
   module_name          varchar(50) not null,
   primary key (id_module),
   constraint fk_submodulo foreign key (mod_id_module)
      references module (id_module) on delete restrict on update restrict,
   constraint fk_module_status foreign key (id_catalog)
      references catalogue (id_catalog) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: menu                                                  */
/*==============================================================*/
create table menu
(
   id_menu              int not null AUTO_INCREMENT,
   id_module            int,
   id_catalog           int,
   menu_code            varchar(50) not null,
   menu_name            varchar(50) not null,
   menu_link            varchar(200) not null,
   primary key (id_menu),
   constraint fk_correspond foreign key (id_module)
      references module (id_module) on delete restrict on update restrict,
   constraint fk_menu_status foreign key (id_catalog)
      references catalogue (id_catalog) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: merchant                                              */
/*==============================================================*/
create table merchant
(
   id_merchant          int not null AUTO_INCREMENT,
   id_catalog           int,
   cat_id_catalog       int,
   cat_id_catalog2      int,
   id_person            int,
   merchant_name        varchar(200),
   address              varchar(200),
   points               int,
   city                 varchar(100),
   country              varchar(100),
   website              varchar(999),
   approval_date        datetime,
   registration_date    datetime not null,
   primary key (id_merchant),
   constraint fk_merchant_owner_person foreign key (id_person)
      references person (id_person) on delete restrict on update restrict,
   constraint fk_merchant_status_approval foreign key (cat_id_catalog2)
      references catalogue (id_catalog) on delete restrict on update restrict,
   constraint fk_merchant_status foreign key (id_catalog)
      references catalogue (id_catalog) on delete restrict on update restrict,
   constraint fk_merchant_category foreign key (cat_id_catalog)
      references catalogue (id_catalog) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: receip                                                */
/*==============================================================*/
create table receip
(
   id_receip            int not null AUTO_INCREMENT,
   id_person            int,
   id_merchant          int,
   id_catalog           int,
   merchant_name        varchar(200) not null,
   amount               decimal not null,
   date_emission        datetime not null,
   date_registration    datetime not null,
   incentive_points     int,
   primary key (id_receip),
   constraint fk_receip_merchant foreign key (id_merchant)
      references merchant (id_merchant) on delete restrict on update restrict,
   constraint fk_person_upload_receip foreign key (id_person)
      references person (id_person) on delete restrict on update restrict,
   constraint fk_receip_approbation foreign key (id_catalog)
      references catalogue (id_catalog) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: picturepool                                           */
/*==============================================================*/
create table picturepool
(
   id_picture_pool      int not null AUTO_INCREMENT,
   id_receip            int,
   id_file              int,
   creation_date        datetime not null,
   primary key (id_picture_pool),
   constraint fk_receip_picture_pool foreign key (id_receip)
      references receip (id_receip) on delete restrict on update restrict,
   constraint fk_picture_pool_files foreign key (id_file)
      references file (id_file) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: pincode                                               */
/*==============================================================*/
create table pincode
(
   id_pincode           int not null AUTO_INCREMENT,
   id_catalog           int,
   id_person            int,
   plastic_brand        varchar(25),
   name_displayed       varchar(200) not null,
   pin_code             varchar(16) not null,
   status               varchar(10),
   city                 varchar(100),
   country              varchar(100),
   continent            varchar(20),
   expiration_date      varchar(5),
   primary key (id_pincode),
   constraint fk_person_pincodes foreign key (id_person)
      references person (id_person) on delete restrict on update restrict,
   constraint fk_pin_status foreign key (id_catalog)
      references catalogue (id_catalog) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: product                                               */
/*==============================================================*/
create table product
(
   id_product           int not null AUTO_INCREMENT,
   id_merchant          int,
   id_catalog           int,
   id_file              int,
   name                 varchar(200) not null,
   description          varchar(200) not null,
   discount             decimal,
   points               int,
   primary key (id_product),
   constraint fk_merchant_product foreign key (id_merchant)
      references merchant (id_merchant) on delete restrict on update restrict,
   constraint fk_product_status foreign key (id_catalog)
      references catalogue (id_catalog) on delete restrict on update restrict,
   constraint fk_photo_product foreign key (id_file)
      references file (id_file) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: profile                                               */
/*==============================================================*/
create table profile
(
   id_profile           int not null AUTO_INCREMENT,
   id_catalog           int,
   profile_code         varchar(50) not null,
   profile_name         varchar(50) not null,
   primary key (id_profile),
   constraint fk_profile_status foreign key (id_catalog)
      references catalogue (id_catalog) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: profile_module                                        */
/*==============================================================*/
create table profile_module
(
   id_profile           int not null,
   id_module            int not null,
   primary key (id_profile, id_module),
   constraint fk_profile_module foreign key (id_profile)
      references profile (id_profile) on delete restrict on update restrict,
   constraint fk_profile_module2 foreign key (id_module)
      references module (id_module) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: reward                                                */
/*==============================================================*/
create table reward
(
   id_reward            int not null AUTO_INCREMENT,
   id_catalog           int,
   name_reward          varchar(100) not null,
   description_reward   varchar(999),
   rule_reward          varchar(9999),
   incentive_points     int,
   primary key (id_reward),
   constraint fk_reward_status foreign key (id_catalog)
      references catalogue (id_catalog) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: user                                                  */
/*==============================================================*/
create table user
(
   id_user              int not null AUTO_INCREMENT,
   id_person            int,
   id_catalog           int,
   username             varchar(255),
   password             varchar(255),
   plainpassword        varchar(255),
   unique_id            varchar(200) not null,
   email                varchar(100) not null,
   salt                 varchar(50),
   roles                varchar(100),
   app_key              varchar(191),
   created_at           datetime,
   updated_at           datetime,
   primary key (id_user),
   constraint fk_person_user foreign key (id_person)
      references person (id_person) on delete restrict on update restrict,
   constraint fk_user_status foreign key (id_catalog)
      references catalogue (id_catalog) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: socialnetwork                                         */
/*==============================================================*/
create table socialnetwork
(
   id_social_network    int not null AUTO_INCREMENT,
   id_user              int,
   network              varchar(200) not null,
   id_network           varchar(200) not null,
   status               varchar(10) not null,
   observation          varchar(200),
   primary key (id_social_network),
   constraint fk_user_socialnetwork foreign key (id_user)
      references user (id_user) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: transaction                                           */
/*==============================================================*/
create table transaction
(
   id_transaction       int not null AUTO_INCREMENT,
   id_account           int,
   id_catalog           int,
   date_transaction     datetime not null,
   points               int not null,
   debit_credit         char(1) not null,
   description          varchar(200),
   primary key (id_transaction),
   constraint fk_transaction_type foreign key (id_catalog)
      references catalogue (id_catalog) on delete restrict on update restrict,
   constraint fk_account_transaction foreign key (id_account)
      references account (id_account) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: user_has_profile                                      */
/*==============================================================*/
create table user_has_profile
(
   id_user              int not null,
   id_profile           int not null,
   primary key (id_user, id_profile),
   constraint fk_user_has_profile foreign key (id_user)
      references user (id_user) on delete restrict on update restrict,
   constraint fk_user_has_profile2 foreign key (id_profile)
      references profile (id_profile) on delete restrict on update restrict
);



alter table user rename column id_catalog to id_user_status;

alter table transaction rename column id_catalog to id_transaction_type;

alter table reward rename column id_catalog to id_reward_status;

alter table receip rename column id_catalog to id_receip_approbation;

alter table receip rename column id_person to id_person_upload_receip;

alter table profile rename column id_catalog to id_profile_status;

alter table product rename column id_catalog to id_product_status;

alter table product rename column id_file to id_photo_product;

alter table pincode rename column id_catalog to id_pin_status;

alter table person rename column id_catalog to id_person_status;

alter table person rename column id_file to id_person_picture;

alter table person rename column cat_id_catalog to id_client_location;

alter table module rename column mod_id_module to id_submodule;

alter table module rename column id_catalog to id_module_status;

alter table merchant rename column cat_id_catalog2 to id_merchant_status_approval;

alter table merchant rename column id_catalog to id_merchant_status;

alter table merchant rename column cat_id_catalog to id_merchant_category;

alter table menu rename column id_catalog to id_menu_status;

alter table catalogue rename column cat_id_catalog to id_parent;


        ');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
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

        ');
    }
}
