#
# Table structure for table 'tx_kequestionnaire_domain_model_question'
#

#
# Table structure for table 'tx_kequestionnaire_domain_model_questionnaire' Unused ??
#
# CREATE TABLE tx_kequestionnaire_domain_model_questionnaire (
#	uid int(11) NOT NULL auto_increment,
#	pid int(11) default 0 ,
#  PRIMARY KEY (uid)
#);


CREATE TABLE tx_kequestionnaire_domain_model_question
(

  uid              int(11)                         NOT NULL auto_increment,
  pid              int(11)             DEFAULT '0' NOT NULL,

  type             varchar(255)        DEFAULT ''  NOT NULL,
  title            varchar(255)        DEFAULT ''  NOT NULL,
  show_title       tinyint(4) unsigned DEFAULT '0' NOT NULL,
  text             text                            NOT NULL,
  help_text        text                            NULL,
  image            text                            NULL,
  image_position   varchar(255)        DEFAULT ''  NOT NULL,
  is_mandatory     tinyint(1) unsigned DEFAULT '0' NOT NULL,
  must_be_correct  tinyint(1) unsigned DEFAULT '0' NOT NULL,
  answers          int(11) unsigned    DEFAULT '0' NOT NULL,
  random_answers   tinyint(1) unsigned DEFAULT '0' NOT NULL,
  column_count     int(11) unsigned    DEFAULT '0' NOT NULL,
  max_answers      int(11)             DEFAULT '0' NOT NULL,
  min_answers      int(11)             DEFAULT '0' NOT NULL,
  content_id       int(11) unsigned    DEFAULT '0' NOT NULL,
  dependancies     int(11) unsigned    DEFAULT '0' NOT NULL,
  to_page          int(11) unsigned    DEFAULT '0' NOT NULL,
  direct_jump      tinyint(4) unsigned DEFAULT '0' NOT NULL,
  javascript       text                            NULL,
  only_js          tinyint(4) unsigned DEFAULT '0' NOT NULL,
  css              text                            NULL,
  template         varchar(255)        DEFAULT ''  NOT NULL,

  tstamp           int(11) unsigned    DEFAULT '0' NOT NULL,
  crdate           int(11) unsigned    DEFAULT '0' NOT NULL,
  cruser_id        int(11) unsigned    DEFAULT '0' NOT NULL,
  deleted          tinyint(4) unsigned DEFAULT '0' NOT NULL,
  hidden           tinyint(4) unsigned DEFAULT '0' NOT NULL,
  starttime        int(11) unsigned    DEFAULT '0' NOT NULL,
  endtime          int(11) unsigned    DEFAULT '0' NOT NULL,

  t3ver_oid        int(11)             DEFAULT '0' NOT NULL,
  t3ver_id         int(11)             DEFAULT '0' NOT NULL,
  t3ver_wsid       int(11)             DEFAULT '0' NOT NULL,
  t3ver_label      varchar(255)        DEFAULT ''  NOT NULL,
  t3ver_state      tinyint(4)          DEFAULT '0' NOT NULL,
  t3ver_stage      int(11)             DEFAULT '0' NOT NULL,
  t3ver_count      int(11)             DEFAULT '0' NOT NULL,
  t3ver_tstamp     int(11)             DEFAULT '0' NOT NULL,
  t3ver_move_id    int(11)             DEFAULT '0' NOT NULL,

  sorting          int(11)             DEFAULT '0' NOT NULL,
  t3_origuid       int(11)             DEFAULT '0' NOT NULL,
  sys_language_uid int(11)             DEFAULT '0' NOT NULL,
  l10n_parent      int(11)             DEFAULT '0' NOT NULL,
  l10n_diffsource  mediumblob,

  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)

);

#
# Table structure for table 'tx_kequestionnaire_domain_model_answer'
#
CREATE TABLE tx_kequestionnaire_domain_model_answer
(

  uid                    int(11)                              NOT NULL auto_increment,
  pid                    int(11)             DEFAULT '0'      NOT NULL,

  question               int(11) unsigned    DEFAULT '0'      NOT NULL,
  answer                 int(11) unsigned    DEFAULT '0'      NOT NULL,

  type                   varchar(255)        DEFAULT ''       NOT NULL,
  title                  varchar(512)        DEFAULT ''       NOT NULL,
  points                 int(11)             DEFAULT '0'      NOT NULL,
  text                   text                                 NOT NULL,
  is_correct_answer      tinyint(4) unsigned DEFAULT '0'      NOT NULL,
  width                  int(11)             DEFAULT '0'      NOT NULL,
  height                 int(11)             DEFAULT '0'      NOT NULL,
  pre_text               varchar(255)        DEFAULT ''       NOT NULL,
  in_text                varchar(255)        DEFAULT ''       NOT NULL,
  post_text              varchar(255)        DEFAULT ''       NOT NULL,
  max_chars              int(11)             DEFAULT '0'      NOT NULL,
  validation_type        varchar(255)        DEFAULT ''       NOT NULL,
  validation_text        text                                 NULL,
  validation_keys_amount int(11)             DEFAULT '0'      NOT NULL,
  comparison_text        text                                 NULL,
  cloze_position         int(11)             DEFAULT '0'      NOT NULL,
  cloze_add_terms        text                                 NULL,
  image                  text                                 NULL,
  coords                 text                                 NULL,
  area_index             int(11)             DEFAULT '0'      NOT NULL,
  area_highlight         tinyint(4)          DEFAULT '0'      NOT NULL,
  cols                   int(11) unsigned    DEFAULT '0'      NOT NULL,
  show_textfield         tinyint(4) unsigned DEFAULT '0'      NOT NULL,
  max_answers            int(11)             DEFAULT '0'      NOT NULL,
  min_answers            int(11)             DEFAULT '0'      NOT NULL,
  select_values          text                                 NULL,
  left_label             varchar(255)        DEFAULT ''       NOT NULL,
  right_label            varchar(255)        DEFAULT ''       NOT NULL,
  min_value              int(11)             DEFAULT '0'      NOT NULL,
  max_value              int(11)             DEFAULT '0'      NOT NULL,
  slider_increment       float(8, 4)         DEFAULT '0.0000' NOT NULL,
  show_steps             tinyint(4)          DEFAULT '0'      NOT NULL,
  step_labels            text                                 NULL,
  avatar_parts           text                                 NULL,
  source_dir             text                                 NULL,
  destination_dir        text                                 NULL,
  feuser_field           text                                 NULL,
  template               varchar(255)        DEFAULT ''       NOT NULL,
  add_clones             tinyint(4)          DEFAULT '0'      NOT NULL,
  title_line             tinyint(4)          DEFAULT '0'      NOT NULL,
  points_start           int(11)             DEFAULT '0'      NOT NULL,
  points_increase        int(11)             DEFAULT '0'      NOT NULL,

  tstamp                 int(11) unsigned    DEFAULT '0'      NOT NULL,
  crdate                 int(11) unsigned    DEFAULT '0'      NOT NULL,
  cruser_id              int(11) unsigned    DEFAULT '0'      NOT NULL,
  deleted                tinyint(4) unsigned DEFAULT '0'      NOT NULL,
  hidden                 tinyint(4) unsigned DEFAULT '0'      NOT NULL,
  starttime              int(11) unsigned    DEFAULT '0'      NOT NULL,
  endtime                int(11) unsigned    DEFAULT '0'      NOT NULL,

  t3ver_oid              int(11)             DEFAULT '0'      NOT NULL,
  t3ver_id               int(11)             DEFAULT '0'      NOT NULL,
  t3ver_wsid             int(11)             DEFAULT '0'      NOT NULL,
  t3ver_label            varchar(255)        DEFAULT ''       NOT NULL,
  t3ver_state            tinyint(4)          DEFAULT '0'      NOT NULL,
  t3ver_stage            int(11)             DEFAULT '0'      NOT NULL,
  t3ver_count            int(11)             DEFAULT '0'      NOT NULL,
  t3ver_tstamp           int(11)             DEFAULT '0'      NOT NULL,
  t3ver_move_id          int(11)             DEFAULT '0'      NOT NULL,

  sorting                int(11)             DEFAULT '0'      NOT NULL,
  t3_origuid             int(11)             DEFAULT '0'      NOT NULL,
  sys_language_uid       int(11)             DEFAULT '0'      NOT NULL,
  l10n_parent            int(11)             DEFAULT '0'      NOT NULL,
  l10n_diffsource        mediumblob,

  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)

);

#
# Table structure for table 'tx_kequestionnaire_domain_model_result'
#
CREATE TABLE tx_kequestionnaire_domain_model_result
(

  uid              int(11)                         NOT NULL auto_increment,
  pid              int(11)             DEFAULT '0' NOT NULL,

  finished         int(11)             DEFAULT '0' NOT NULL,
  questions        int(11) unsigned    DEFAULT '0' NOT NULL,
  points           int(11)             DEFAULT '0' NOT NULL,
  max_points       int(11)             DEFAULT '0' NOT NULL,
  fe_user          int(11)             DEFAULT '0' NOT NULL,
  auth_code        int(11)             DEFAULT '0' NOT NULL,
  add_parameter    varchar(255)        DEFAULT ''  NOT NULL,

  tstamp           int(11) unsigned    DEFAULT '0' NOT NULL,
  crdate           int(11) unsigned    DEFAULT '0' NOT NULL,
  cruser_id        int(11) unsigned    DEFAULT '0' NOT NULL,
  fe_cruser_id     int(11) unsigned    DEFAULT '0' NOT NULL,
  deleted          tinyint(4) unsigned DEFAULT '0' NOT NULL,
  hidden           tinyint(4) unsigned DEFAULT '0' NOT NULL,
  starttime        int(11) unsigned    DEFAULT '0' NOT NULL,
  endtime          int(11) unsigned    DEFAULT '0' NOT NULL,

  t3ver_oid        int(11)             DEFAULT '0' NOT NULL,
  t3ver_id         int(11)             DEFAULT '0' NOT NULL,
  t3ver_wsid       int(11)             DEFAULT '0' NOT NULL,
  t3ver_label      varchar(255)        DEFAULT ''  NOT NULL,
  t3ver_state      tinyint(4)          DEFAULT '0' NOT NULL,
  t3ver_stage      int(11)             DEFAULT '0' NOT NULL,
  t3ver_count      int(11)             DEFAULT '0' NOT NULL,
  t3ver_tstamp     int(11)             DEFAULT '0' NOT NULL,
  t3ver_move_id    int(11)             DEFAULT '0' NOT NULL,

  t3_origuid       int(11)             DEFAULT '0' NOT NULL,
  sys_language_uid int(11)             DEFAULT '0' NOT NULL,
  l10n_parent      int(11)             DEFAULT '0' NOT NULL,
  l10n_diffsource  mediumblob,

  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)

);

#
# Table structure for table 'tx_kequestionnaire_domain_model_resultquestion'
#
CREATE TABLE tx_kequestionnaire_domain_model_resultquestion
(

  uid              int(11)                         NOT NULL auto_increment,
  pid              int(11)             DEFAULT '0' NOT NULL,

  result           int(11) unsigned    DEFAULT '0' NOT NULL,

  answers          int(11) unsigned    DEFAULT '0' NOT NULL,
  question         int(11) unsigned    DEFAULT '0',
  points           int(11)             DEFAULT '0' NOT NULL,
  max_points       int(11)             DEFAULT '0' NOT NULL,

  tstamp           int(11) unsigned    DEFAULT '0' NOT NULL,
  crdate           int(11) unsigned    DEFAULT '0' NOT NULL,
  cruser_id        int(11) unsigned    DEFAULT '0' NOT NULL,
  fe_cruser_id     int(11) unsigned    DEFAULT '0' NOT NULL,
  deleted          tinyint(4) unsigned DEFAULT '0' NOT NULL,
  hidden           tinyint(4) unsigned DEFAULT '0' NOT NULL,
  starttime        int(11) unsigned    DEFAULT '0' NOT NULL,
  endtime          int(11) unsigned    DEFAULT '0' NOT NULL,

  t3ver_oid        int(11)             DEFAULT '0' NOT NULL,
  t3ver_id         int(11)             DEFAULT '0' NOT NULL,
  t3ver_wsid       int(11)             DEFAULT '0' NOT NULL,
  t3ver_label      varchar(255)        DEFAULT ''  NOT NULL,
  t3ver_state      tinyint(4)          DEFAULT '0' NOT NULL,
  t3ver_stage      int(11)             DEFAULT '0' NOT NULL,
  t3ver_count      int(11)             DEFAULT '0' NOT NULL,
  t3ver_tstamp     int(11)             DEFAULT '0' NOT NULL,
  t3ver_move_id    int(11)             DEFAULT '0' NOT NULL,

  t3_origuid       int(11)             DEFAULT '0' NOT NULL,
  sys_language_uid int(11)             DEFAULT '0' NOT NULL,
  l10n_parent      int(11)             DEFAULT '0' NOT NULL,
  l10n_diffsource  mediumblob,

  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)

);

#
# Table structure for table 'tx_kequestionnaire_domain_model_resultanswer'
#
CREATE TABLE tx_kequestionnaire_domain_model_resultanswer
(

  uid              int(11)                         NOT NULL auto_increment,
  pid              int(11)             DEFAULT '0' NOT NULL,

  resultquestion   int(11) unsigned    DEFAULT '0' NOT NULL,

  answer           int(11) unsigned    DEFAULT '0',
  value            text                            NOT NULL,
  col              varchar(255)        DEFAULT ''  NOT NULL,
  clone            tinyint(4) unsigned DEFAULT '0' NOT NULL,
  clone_title      varchar(255)        DEFAULT ''  NOT NULL,
  additional_value varchar(255)        DEFAULT ''  NOT NULL,

  tstamp           int(11) unsigned    DEFAULT '0' NOT NULL,
  crdate           int(11) unsigned    DEFAULT '0' NOT NULL,
  cruser_id        int(11) unsigned    DEFAULT '0' NOT NULL,
  fe_cruser_id     int(11) unsigned    DEFAULT '0' NOT NULL,
  deleted          tinyint(4) unsigned DEFAULT '0' NOT NULL,
  hidden           tinyint(4) unsigned DEFAULT '0' NOT NULL,
  starttime        int(11) unsigned    DEFAULT '0' NOT NULL,
  endtime          int(11) unsigned    DEFAULT '0' NOT NULL,

  t3ver_oid        int(11)             DEFAULT '0' NOT NULL,
  t3ver_id         int(11)             DEFAULT '0' NOT NULL,
  t3ver_wsid       int(11)             DEFAULT '0' NOT NULL,
  t3ver_label      varchar(255)        DEFAULT ''  NOT NULL,
  t3ver_state      tinyint(4)          DEFAULT '0' NOT NULL,
  t3ver_stage      int(11)             DEFAULT '0' NOT NULL,
  t3ver_count      int(11)             DEFAULT '0' NOT NULL,
  t3ver_tstamp     int(11)             DEFAULT '0' NOT NULL,
  t3ver_move_id    int(11)             DEFAULT '0' NOT NULL,

  sorting          int(11)             DEFAULT '0' NOT NULL,
  t3_origuid       int(11)             DEFAULT '0' NOT NULL,
  sys_language_uid int(11)             DEFAULT '0' NOT NULL,
  l10n_parent      int(11)             DEFAULT '0' NOT NULL,
  l10n_diffsource  mediumblob,

  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)

);

#
# Table structure for table 'tx_kequestionnaire_domain_model_range'
#
CREATE TABLE tx_kequestionnaire_domain_model_range
(

  uid              int(11)                         NOT NULL auto_increment,
  pid              int(11)             DEFAULT '0' NOT NULL,

  title            varchar(255)        DEFAULT ''  NOT NULL,
  text             text                            NOT NULL,
  points_from      int(11) unsigned    DEFAULT '0' NOT NULL,
  points_until     int(11) unsigned    DEFAULT '0' NOT NULL,

  tstamp           int(11) unsigned    DEFAULT '0' NOT NULL,
  crdate           int(11) unsigned    DEFAULT '0' NOT NULL,
  cruser_id        int(11) unsigned    DEFAULT '0' NOT NULL,
  deleted          tinyint(4) unsigned DEFAULT '0' NOT NULL,
  hidden           tinyint(4) unsigned DEFAULT '0' NOT NULL,
  starttime        int(11) unsigned    DEFAULT '0' NOT NULL,
  endtime          int(11) unsigned    DEFAULT '0' NOT NULL,

  t3ver_oid        int(11)             DEFAULT '0' NOT NULL,
  t3ver_id         int(11)             DEFAULT '0' NOT NULL,
  t3ver_wsid       int(11)             DEFAULT '0' NOT NULL,
  t3ver_label      varchar(255)        DEFAULT ''  NOT NULL,
  t3ver_state      tinyint(4)          DEFAULT '0' NOT NULL,
  t3ver_stage      int(11)             DEFAULT '0' NOT NULL,
  t3ver_count      int(11)             DEFAULT '0' NOT NULL,
  t3ver_tstamp     int(11)             DEFAULT '0' NOT NULL,
  t3ver_move_id    int(11)             DEFAULT '0' NOT NULL,

  sorting          int(11)             DEFAULT '0' NOT NULL,
  t3_origuid       int(11)             DEFAULT '0' NOT NULL,
  sys_language_uid int(11)             DEFAULT '0' NOT NULL,
  l10n_parent      int(11)             DEFAULT '0' NOT NULL,
  l10n_diffsource  mediumblob,

  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)

);

#
# Table structure for table 'tx_kequestionnaire_domain_model_answer'
#
CREATE TABLE tx_kequestionnaire_domain_model_answer
(

  question int(11) unsigned DEFAULT '0' NOT NULL

);

#
# Table structure for table 'tx_kequestionnaire_domain_model_resultanswer'
#
CREATE TABLE tx_kequestionnaire_domain_model_resultanswer
(

  resultquestion int(11) unsigned DEFAULT '0' NOT NULL

);

#
# Table structure for table 'tx_kequestionnaire_domain_model_resultquestion'
#
CREATE TABLE tx_kequestionnaire_domain_model_resultquestion
(

  result int(11) unsigned DEFAULT '0' NOT NULL

);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

#
# Table structure for table 'tx_kequestionnaire_domain_model_authcode'
#
CREATE TABLE tx_kequestionnaire_domain_model_authcode
(

  uid              int(11)                         NOT NULL auto_increment,
  pid              int(11)             DEFAULT '0' NOT NULL,

  auth_code        varchar(255)        DEFAULT ''  NOT NULL,
  email            varchar(255)        DEFAULT ''  NOT NULL,
  fe_user          int(11) unsigned    DEFAULT '0' NOT NULL,
  tt_address       int(11) unsigned    DEFAULT '0' NOT NULL,
  lastreminder     int(11) unsigned    DEFAULT '0' NOT NULL,
  firstactive      int(11) unsigned    DEFAULT '0' NOT NULL,

  tstamp           int(11) unsigned    DEFAULT '0' NOT NULL,
  crdate           int(11) unsigned    DEFAULT '0' NOT NULL,
  cruser_id        int(11) unsigned    DEFAULT '0' NOT NULL,
  fe_cruser_id     int(11) unsigned    DEFAULT '0' NOT NULL,
  deleted          tinyint(4) unsigned DEFAULT '0' NOT NULL,
  hidden           tinyint(4) unsigned DEFAULT '0' NOT NULL,
  starttime        int(11) unsigned    DEFAULT '0' NOT NULL,
  endtime          int(11) unsigned    DEFAULT '0' NOT NULL,

  t3ver_oid        int(11)             DEFAULT '0' NOT NULL,
  t3ver_id         int(11)             DEFAULT '0' NOT NULL,
  t3ver_wsid       int(11)             DEFAULT '0' NOT NULL,
  t3ver_label      varchar(255)        DEFAULT ''  NOT NULL,
  t3ver_state      tinyint(4)          DEFAULT '0' NOT NULL,
  t3ver_stage      int(11)             DEFAULT '0' NOT NULL,
  t3ver_count      int(11)             DEFAULT '0' NOT NULL,
  t3ver_tstamp     int(11)             DEFAULT '0' NOT NULL,
  t3ver_move_id    int(11)             DEFAULT '0' NOT NULL,

  t3_origuid       int(11)             DEFAULT '0' NOT NULL,
  sys_language_uid int(11)             DEFAULT '0' NOT NULL,
  l10n_parent      int(11)             DEFAULT '0' NOT NULL,
  l10n_diffsource  mediumblob,

  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)

);

#
# Table structure for table 'tx_kequestionnaire_domain_model_dependancy'
#
CREATE TABLE tx_kequestionnaire_domain_model_dependancy
(

  uid              int(11)                         NOT NULL auto_increment,
  pid              int(11)             DEFAULT '0' NOT NULL,

  relation         varchar(255)        DEFAULT ''  NOT NULL,
  answer           int(11) unsigned    DEFAULT '0' NOT NULL,
  dquestion        int(11) unsigned    DEFAULT '0' NOT NULL,

  tstamp           int(11) unsigned    DEFAULT '0' NOT NULL,
  crdate           int(11) unsigned    DEFAULT '0' NOT NULL,
  cruser_id        int(11) unsigned    DEFAULT '0' NOT NULL,
  fe_cruser_id     int(11) unsigned    DEFAULT '0' NOT NULL,
  deleted          tinyint(4) unsigned DEFAULT '0' NOT NULL,
  hidden           tinyint(4) unsigned DEFAULT '0' NOT NULL,
  starttime        int(11) unsigned    DEFAULT '0' NOT NULL,
  endtime          int(11) unsigned    DEFAULT '0' NOT NULL,

  t3ver_oid        int(11)             DEFAULT '0' NOT NULL,
  t3ver_id         int(11)             DEFAULT '0' NOT NULL,
  t3ver_wsid       int(11)             DEFAULT '0' NOT NULL,
  t3ver_label      varchar(255)        DEFAULT ''  NOT NULL,
  t3ver_state      tinyint(4)          DEFAULT '0' NOT NULL,
  t3ver_stage      int(11)             DEFAULT '0' NOT NULL,
  t3ver_count      int(11)             DEFAULT '0' NOT NULL,
  t3ver_tstamp     int(11)             DEFAULT '0' NOT NULL,
  t3ver_move_id    int(11)             DEFAULT '0' NOT NULL,

  t3_origuid       int(11)             DEFAULT '0' NOT NULL,
  sys_language_uid int(11)             DEFAULT '0' NOT NULL,
  l10n_parent      int(11)             DEFAULT '0' NOT NULL,
  l10n_diffsource  mediumblob,

  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY t3ver_oid (t3ver_oid, t3ver_wsid),
  KEY language (l10n_parent, sys_language_uid)

);