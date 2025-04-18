<?php
require 'app/functions/helpers.php';
require 'app/classes/Uri.php';
require 'app/classes/training/TableElement.php';
require 'app/classes/training/Employed.php';
require 'app/classes/training/Job.php';
require 'app/classes/training/TrainingRegister.php';
require 'app/classes/training/StatusTraining.php';
require 'app/classes/training/Date.php';
require 'app/classes/training/Prospector.php';
require 'app/classes/training/TablePath.php';
require 'app/classes/training/HeaderForm.php';
require 'app/classes/training/Header.php';
require 'app/classes/training/Register.php';

#Model
require 'app/models/Query.php';
require 'app/models/ModelRegister.php';
require 'app/models/ReportTraining.php';
require 'app/models/UpdateRegisterDataBase.php';
require 'app/models/ModelAdmin.php';

#Admin
require 'app/classes/admin/RelationStructs.php';
require 'app/classes/admin/general_structs/Struct.php';
require 'app/classes/admin/general_structs/Id.php';
require 'app/classes/admin/general_structs/Name.php';
require 'app/classes/admin/employed_structs/Mat.php';
require 'app/classes/admin/employed_structs/Email.php';
require 'app/classes/admin/employed_structs/Tel.php';
require 'app/classes/admin/Training.php';
require 'app/classes/admin/Employed.php';
require 'app/classes/admin/Job.php';
require 'app/classes/admin/CollectionEmployed.php';
require 'app/classes/admin/CollectionTraininig.php';
require 'app/classes/admin/CollectionJob.php';

require 'core/Controller.php';
require 'core/Method.php';
require 'core/Parameter.php';
require 'app/controllers/Home.php';
require 'app/controllers/SignUp.php';
require 'app/controllers/SignIn.php';
require 'app/controllers/Training.php';
require 'app/controllers/Admin.php';
require 'app/views/View.php';
require 'app/views/Home.php';
require 'app/views/SignUp.php';
require 'app/views/SignIn.php';
require 'app/views/RenderTraining.php';
require 'app/views/RenderReceiverXls.php';
require 'config/ConfigEnv.php';
require 'config/Defines.php';
require 'vendor/autoload.php';
