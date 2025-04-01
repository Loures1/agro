<?php

namespace app\classes\admin;

use app\classes\admin\employed_structs\Id;
use app\classes\admin\employed_structs\Name;
use app\classes\admin\employed_structs\Mat;
use app\classes\admin\employed_structs\Tel;
use app\classes\admin\employed_structs\Email;
use app\classes\admin\Job;
use app\classes\admin\CollectionTraining;
use DateTime;

class Employed
{
  private Id $id;
  private Name $name;
  private Mat $mat;
  private Job $job;
  private CollectionTraining $trainings;
  private Tel $telefone;
  private Email $email;
  private DateTime $date;
}
