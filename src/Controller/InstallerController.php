<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\Controller\Exception\SecurityException;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Routing\Router;

class InstallerController extends AppController
{
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
		if (isset($this->request->params['admin'])) {
            $this->Security->requireSecure();
        }
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['index',"gymTableInstall","success","updateSys"]);
    }
	
	public function initialize()
    {
        parent::initialize();
		$this->viewBuilder()->layout("gym_install");
		$this->loadComponent('Csrf');
        $this->loadComponent('Security',['blackHoleCallback' => 'forceSSL']);
    }
	
	public function forceSSL()
    {
        // return $this->redirect('https://' . env('SERVER_NAME') . $this->request->here);
    }
	
	public function index()
	{
		/* passthru("nohup mysql -u root -p DBNAME < dump.sql"); */
		if (file_exists(TMP.'installed.txt')) 
		{ 
			return $this->redirect(["controller"=>"users"]);
			die;
		}
		if($this->request->is("post"))
		{	
			$file = ROOT . DS . 'config'. DS . 'app.php';       
			$content = file_get_contents($file);	
			
			$api_file = WWW_ROOT . 'nghome'. DS . 'connection.php';
			$api_content = file_get_contents($api_file);
			$base_url = Router::url('/', true);
			$upload_url = $base_url . "webroot/upload/";
			
			$db_host = $this->request->data["db_host"];
			$db_username = $this->request->data["db_username"];
			$db_pass = $this->request->data["db_pass"];
			$db_name = $this->request->data["db_name"];
			
			
			$con = mysqli_connect($db_host,$db_username,$db_pass,$db_name);		
			if (mysqli_connect_errno())
			{
				echo "Failed to connect to Database : " . mysqli_connect_error();
				die;
			}
		  
			$content = str_replace(["CUST_HOST","CUST_USERNAME","CUST_PW","CUST_DB_NAME"],[$db_host,$db_username,$db_pass,$db_name],$content);
			$status = file_put_contents($file, $content);
			
			$api_content = str_replace(["CUST_HOST","CUST_USERNAME","CUST_PW","CUST_DB_NAME","CUST_URL","UPLOAD_URL"],[$db_host,$db_username,$db_pass,$db_name,$base_url,$upload_url],$api_content);
			$api_status = file_put_contents($api_file, $api_content);
			
			$this->gymTableInstall($db_name,$db_username,$db_host,$db_pass);
			$this->insertData($this->request->data);
		}
	}
	
	private function gymTableInstall($db_name,$db_username,$db_host,$db_pass)
    {		
		$this->viewBuilder()->layout("");
		$this->autoRender = false;	
				
		$config = [
					'className' => 'Cake\Database\Connection',
					'driver' => 'Cake\Database\Driver\Mysql',
					'persistent' => false,
					'host' => $db_host,
					'username' => $db_username,
					'password' => $db_pass,
					'database' => $db_name,
					'encoding' => 'utf8',
					'timezone' => 'UTC',
					'flags' => [],
					'cacheMetadata' => true,
					'log' => false,
					'quoteIdentifiers' => false,           
					'url' => env('DATABASE_URL', null)
				];
			
		ConnectionManager::config('install_db', $config);
		$conn = ConnectionManager::get('install_db');		
		
/* 		$sql = "CREATE DATABASE IF NOT EXISTS `{$db_name}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
		$stmt = $conn->execute($sql); */		
		
		$sql="CREATE TABLE IF NOT EXISTS `activity` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `cat_id` int(11) NULL,
			  `title` varchar(100) NULL,
			  `assigned_to` int(11) NULL,
			  `created_by` int(11) NULL,
			  `created_date` date NULL,
			  PRIMARY KEY (`id`)
			)DEFAULT CHARSET=utf8";
		
		$stmt = $conn->execute($sql);
		
		$sql="CREATE TABLE IF NOT EXISTS `category` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(100) NULL,
			  PRIMARY KEY (`id`)
			)DEFAULT CHARSET=utf8";
		
		$stmt = $conn->execute($sql);
		
		$sql="CREATE TABLE IF NOT EXISTS `class_schedule` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `class_name` varchar(100) NULL,
			  `assign_staff_mem` int(11) NULL,
			  `assistant_staff_member` int(11) NULL,
			  `location` varchar(100) NULL,
			  `days` varchar(200) NULL,
			  `start_time` varchar(30) NULL,
			  `end_time` varchar(30) NULL,
			  `created_by` int(11) NULL,
			  `created_date` date NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";
			
		$stmt = $conn->execute($sql);
		
		$sql="CREATE TABLE IF NOT EXISTS `class_schedule_list` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `class_id` int(11) NULL,
			  `days` varchar(255) NULL,
			  `start_time` varchar(20) NULL,
			  `end_time` varchar(20) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";
				
		$stmt = $conn->execute($sql);
				
		$sql="CREATE TABLE IF NOT EXISTS `general_setting` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(100) NULL,
			  `start_year` varchar(50) NULL,
			  `address` varchar(100) NULL,
			  `office_number` varchar(20) NULL,
			  `country` text NULL,
			  `email` varchar(100) NULL,
			  `date_format` varchar(15) NULL,
			  `calendar_lang` text NULL,
			  `gym_logo` varchar(200) NULL,
			  `cover_image` varchar(200) NULL,
			  `weight` varchar(100) NULL,
			  `height` varchar(100) NULL,
			  `chest` varchar(100) NULL,
			  `waist` varchar(100) NULL,
			  `thing` varchar(100) NULL,
			  `arms` varchar(100) NULL,
			  `fat` varchar(100) NULL,
			  `member_can_view_other` int(11) NULL,
			  `staff_can_view_own_member` int(11) NULL,
			  `enable_sandbox` int(11) NULL,
			  `paypal_email` varchar(50) NULL,
			  `currency` varchar(20) NULL,
			  `enable_alert` int(11) NULL,
			  `reminder_days` varchar(100) NULL,
			  `reminder_message` varchar(255) NULL,
			  `enable_message` int(11) NULL,
			  `left_header` varchar(100) NULL,
			  `footer` varchar(100) NULL,
			  `system_installed` int(11) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";		
							
		$stmt = $conn->execute($sql);
					
		$sql="CREATE TABLE IF NOT EXISTS `gym_accessright` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `controller` text NULL,
			  `action` text NULL,
			  `menu` text NULL,
			  `menu_icon` text NULL,
			  `menu_title` text NULL,
			  `member` int(11) NULL,
			  `staff_member` int(11) NULL,
			  `accountant` int(11) NULL,
			  `page_link` text NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";
		
	/* 	$stmt = $conn->execute($sql);	 */	
					
		/* $sql="CREATE TABLE IF NOT EXISTS `gym_accessright` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `controller` text NULL,
			  `action` text NULL,
			  `menu` text NULL,
			  `menu_icon` text NULL,
			  `menu_title` text NULL,
			  `member` int(11) NULL,
			  `staff_member` int(11) NULL,
			  `accountant` int(11) NULL,
			  `page_link` text NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";
				 */
		$path = $this->request->base;		
		$insert ="INSERT INTO `gym_accessright` (`controller`, `action`, `menu`, `menu_icon`, `menu_title`, `member`, `staff_member`, `accountant`, `page_link`) VALUES
					('StaffMembers', '', 'staff_member', 'staff-member.png', 'Staff Members', 1, 1, 1, '".$path."/staff-members/staff-list'),
					('Membership', '', 'membership', 'membership-type.png', 'Membership Type', 1, 1, 0, '".$path."/membership/membership-list'),
					('GymGroup', '', 'group', 'group.png', 'Group', 1, 1, 0, '".$path."/gym-group/group-list'),
					('GymMember', '', 'member', 'member.png', 'Member', 1, 1, 1, '".$path."/gym-member/member-list'),
					('Activity', '', 'activity', 'activity.png', 'Activity', 1, 1, 0, '".$path."/activity/activity-list'),
					('ClassSchedule', '', 'class-schedule', 'class-schedule.png', 'Class Schedule', 1, 1, 0, '".$path."/class-schedule/class-list'),
					('GymAttendance', '', 'attendance', 'attendance.png', 'Attendance', 0, 1, 0, '".$path."/gym-attendance/attendance'),
					('GymAssignWorkout', '', 'assign-workout', 'assigne-workout.png', 'Assigned Workouts', 1, 1, 0, '".$path."/gym-assign-workout/workout-log'),
					('GymDailyWorkout', '', 'workouts', 'workout.png', 'Workouts', 1, 1, 0, '".$path."/gym-daily-workout/workout-list'),
					('GymAccountant', '', 'accountant', 'accountant.png', 'Accountant', 1, 1, 1, '".$path."/gym-accountant/accountant-list'),
					('MembershipPayment', '', 'membership_payment', 'fee.png', 'Fee Payment', 1, 0, 1, '".$path."/membership-payment/payment-list'),
					('MembershipPayment', '', 'income', 'payment.png', 'Income', 0, 0, 1, '".$path."/membership-payment/income-list'),
					('MembershipPayment', '', 'expense', 'payment.png', 'Expense', 0, 0, 1, '".$path."/membership-payment/expense-list'),
					('GymProduct', '', 'product', 'products.png', 'Product', 0, 1, 1, '".$path."/gym-product/product-list'),
					('GymStore', '', 'store', 'store.png', 'Store', 0, 1, 1, '".$path."/gym-store/sell-record'),
					('GymNewsletter', '', 'news_letter', 'newsletter.png', 'Newsletter', 0, 1, 0, '".$path."/gym-newsletter/setting'),
					('GymMessage', '', 'message', 'message.png', 'Message', 1, 1, 1, '".$path."/gym-message/compose-message'),
					('GymNotice', '', 'notice', 'notice.png', 'Notice', 1, 1, 1, '".$path."/gym-notice/notice-list'),
					('GymNutrition', '', 'nutrition', 'nutrition-schedule.png', 'Nutrition Schedule', 1, 1, 0, '".$path."/gym-nutrition/nutrition-list'),
					('GymReservation', '', 'reservation', 'reservation.png', 'Reservation', 1, 1, 1, '".$path."/gym-reservation/reservation-list'),
					('GymProfile', '', 'account', 'account.png', 'Account', 1, 1, 1, '".$path."/GymProfile/view_profile'),
					('GymSubscriptionHistory', '', 'subscription_history', 'subscription_history.png', 'Subscription History', 1, 0, 0, '".$path."/GymSubscriptionHistory/')";
							
		$stmt = $conn->execute($sql);		
		$stmt = $conn->execute($insert);	
			
		$sql="CREATE TABLE IF NOT EXISTS `gym_assign_workout` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `user_id` int(11) NULL,
			  `start_date` date NULL,
			  `end_date` date NULL,
			  `level_id` int(11) NULL,
			  `description` text NULL,
			  `direct_assign` tinyint(1) NULL,
			  `created_date` date NULL,
			  `created_by` int(11) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";
				
		$stmt = $conn->execute($sql);
		
		$sql="CREATE TABLE IF NOT EXISTS `gym_attendance` (
			  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
			  `user_id` int(11) NULL,
			  `class_id` int(11) NULL,
			  `attendance_date` date NULL,
			  `status` varchar(50) NULL,
			  `attendance_by` int(11) NULL,
			  `role_name` varchar(50) NULL,
			  PRIMARY KEY (`attendance_id`)
				)DEFAULT CHARSET=utf8";
		
		$stmt = $conn->execute($sql);
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_daily_workout` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `workout_id` int(11) NULL,
			  `member_id` int(11) NULL,
			  `record_date` date NULL,
			  `result_measurment` varchar(50) NULL,
			  `result` varchar(100) NULL,
			  `duration` varchar(100) NULL,
			  `assigned_by` int(11) NULL,
			  `due_date` date NULL,
			  `time_of_workout` varchar(50) NULL,
			  `status` varchar(100) NULL,
			  `note` text NULL,
			  `created_by` int(11) NULL,
			  `created_date` date NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `id` (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_event_place` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `place` varchar(100) NULL,
			  `created_by` int(11) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";
		
		$stmt = $conn->execute($sql);
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_group` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(200) NULL,
			  `image` varchar(255) NULL,
			  `created_by` int(11) NULL,
			  `created_date` date NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";
		
		$stmt = $conn->execute($sql);
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_income_expense` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `invoice_type` varchar(100) NULL,
			  `invoice_label` varchar(100) NULL,
			  `supplier_name` varchar(100) NULL,
			  `entry` text NULL,
			  `payment_status` varchar(50) NULL,
			  `total_amount` double NULL,
			  `receiver_id` int(11) NULL,
			  `invoice_date` date NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";
				
		$stmt = $conn->execute($sql);		
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_interest_area` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `interest` varchar(100) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";
		
		$stmt = $conn->execute($sql);
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_levels` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `level` varchar(100) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";
		
		$stmt = $conn->execute($sql);
						
		$sql="CREATE TABLE IF NOT EXISTS `gym_measurement` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `result_measurment` varchar(100) DEFAULT NULL,
			  `result` float DEFAULT NULL,
			  `user_id` int(11) NULL,
			  `result_date` date NULL,
			  `image` varchar(50) NULL,
			  `created_by` int(11) NULL,
			  `created_date` date NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);
		
		$sql="CREATE TABLE IF NOT EXISTS `gym_member` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `activated` int(11) NULL,
			  `role_name` text NULL,
			  `member_id` text NULL,
			  `first_name` varchar(100) NULL,
			  `middle_name` varchar(100) NULL,
			  `last_name` varchar(100) NULL,
			  `member_type` text NULL,
			  `role` int(11) NULL,
			  `s_specialization` varchar(255) NULL,
			  `gender` text NULL,
			  `birth_date` date NULL,
			  `assign_class` int(11) NULL,
			  `assign_group` varchar(150) NULL,
			  `address` varchar(100) NULL,
			  `city` varchar(100) NULL,
			  `state` varchar(100) NULL,
			  `zipcode` varchar(100) NULL,
			  `mobile` varchar(20) NULL,
			  `phone` varchar(20) NULL,
			  `email` varchar(100) NULL,
			  `weight` varchar(10) NULL,
			  `height` varchar(10) NULL,
			  `chest` varchar(10) NULL,
			  `waist` varchar(10) NULL,
			  `thing` varchar(10) NULL,
			  `arms` varchar(10) NULL,
			  `fat` varchar(10) NULL,
			  `username` varchar(100) NULL,
			  `password` varchar(255) NULL,
			  `image` varchar(200) NULL,
			  `assign_staff_mem` int(11) NULL,
			  `intrested_area` int(11) NULL,
			  `g_source` int(11) NULL,
			  `referrer_by` int(11) NULL,
			  `inquiry_date` date NULL,
			  `trial_end_date` date NULL,
			  `selected_membership` varchar(100) NULL,
			  `membership_status` text NULL,
			  `membership_valid_from` date NULL,
			  `membership_valid_to` date NULL,
			  `first_pay_date` date NULL,
			  `created_by` int(11) NULL,
			  `created_date` date NULL,
			  `alert_sent` int(11) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$username = $this->request->data["lg_username"];
		$password = $this->request->data["confirm"];
		
		$hasher = new DefaultPasswordHasher();
		$password = $hasher->hash($password);
		$curr_date = date("Y-m-d");
		
		$insert = "INSERT INTO `gym_member` (`role_name`,`first_name`, `middle_name`, `last_name`,`gender`, `birth_date`,`address`, `city`, `state`, `zipcode`, `mobile`, `phone`, `email`,`username`, `password`, `image`,`created_date`) VALUES
		('administrator','Admin', '', '', 'male', '2016-07-01','null', 'null', 't', '123123', '123123123', '', 'admin@admin.com', '{$username}', '{$password}', 'logo.png','{$curr_date}')";
	
		$stmt = $conn->execute($sql);	
		$stmt = $conn->execute($insert);
		
		$pass = "";
		$insert = "INSERT INTO `gym_member` (`role_name`, `member_id`, `first_name`, `middle_name`, `last_name`, `member_type`, `role`, `gender`, `birth_date`, `assign_group`, `address`, `city`, `state`, `zipcode`, `mobile`, `phone`, `email`, `weight`, `height`, `chest`, `waist`, `thing`, `arms`, `fat`, `username`, `password`, `image`, `assign_staff_mem`, `intrested_area`, `g_source`, `referrer_by`, `inquiry_date`, `trial_end_date`, `selected_membership`, `membership_status`, `membership_valid_from`, `membership_valid_to`, `first_pay_date`, `created_by`, `created_date`, `alert_sent`) VALUES
		('staff_member', '', 'Sergio', '', 'Romero', '', 1, 'male', '2016-08-10', '', 'Address line', 'City', '', '', '2288774455', '', 'sergio@sergio.com', '', '', '', '', '', '', '', 'sergio', '{$pass}', 'logo.png', 0, 0, 0, 0, '0000-00-00', '0000-00-00', '', '', '0000-00-00', '0000-00-00', '0000-00-00', 0, '2016-08-22', 0)";
	
		$stmt = $conn->execute($sql);	
		$stmt = $conn->execute($insert);	
		
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_member_class` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `member_id` int(11) NULL,
			  `assign_class` int(11) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";			
				
		$stmt = $conn->execute($sql);	
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_message` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `sender` int(11) NULL,
			  `receiver` int(11) NULL,
			  `date` datetime NULL,
			  `subject` varchar(150) NULL,
			  `message_body` text NULL,
			  `status` int(11) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);				
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_newsletter` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `api_key` varchar(255) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";
		
		$stmt = $conn->execute($sql);		
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_notice` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `notice_title` varchar(100) NULL,
			  `notice_for` text NULL,
			  `class_id` int(11) NULL,
			  `start_date` date NULL,
			  `end_date` date NULL,
			  `comment` varchar(200) NULL,
			  `created_by` int(11) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);		
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_nutrition` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `user_id` int(11) NULL,
			  `day` varchar(50) NULL,
			  `breakfast` text NULL,
			  `midmorning_snack` text NULL,
			  `lunch` text NULL,
			  `afternoon_snack` text NULL,
			  `dinner` text NULL,
			  `afterdinner_snack` text NULL,
			  `start_date` varchar(20) NULL,
			  `expire_date` varchar(20) NULL,
			  `created_by` int(11) NULL,
			  `created_date` date NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);	
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_nutrition_data` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `day_name` varchar(30) NULL,
			  `nutrition_time` varchar(30) NULL,
			  `nutrition_value` text NULL,
			  `nutrition_id` int(11) NULL,
			  `created_date` date NULL,
			  `create_by` int(11) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);			
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_product` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `product_name` varchar(100) NULL,
			  `price` double NULL,
			  `quantity` int(11) NULL,
			  `created_by` int(11) NULL,
			  `created_date` date NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);						
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_reservation` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `event_name` varchar(100) NULL,
			  `event_date` date NULL,
			  `start_time` varchar(20) NULL,
			  `end_time` varchar(20) NULL,
			  `place_id` int(11) NULL,
			  `created_by` int(11) NULL,
			  `created_date` date NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);								
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_roles` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(100) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);	
						
		$sql="CREATE TABLE IF NOT EXISTS `gym_source` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `source_name` varchar(100) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);		
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_store` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `member_id` int(11) NULL,
			  `sell_date` date NULL,
			  `product_id` int(11) NULL,
			  `price` double NULL,
			  `quantity` int(11) NULL,
			  `sell_by` int(11) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);			
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_user_workout` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `user_workout_id` int(11) NULL,
			  `workout_name` int(11) NULL,
			  `sets` int(11) NULL,
			  `reps` int(11) NULL,
			  `kg` float NULL,
			  `rest_time` int(11) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);		
				
		$sql="CREATE TABLE IF NOT EXISTS `gym_workout_data` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `day_name` varchar(15) NULL,
			  `workout_name` varchar(100) NULL,
			  `sets` int(11) NULL,
			  `reps` int(11) NULL,
			  `kg` float NULL,
			  `time` int(11) NULL,
			  `workout_id` int(11) NULL,
			  `created_date` date NULL,
			  `created_by` int(11) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);	
				
		$sql="CREATE TABLE IF NOT EXISTS `installment_plan` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `number` int(11) NULL,
			  `duration` varchar(50) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);
				
		$sql="CREATE TABLE IF NOT EXISTS `membership` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `membership_label` varchar(100) NULL,
			  `membership_cat_id` int(11) NULL,
			  `membership_length` int(11) NULL,
			  `membership_class_limit` varchar(20) NULL,
			  `limit_days` int(11) NULL,
			  `limitation` varchar(20) NULL,
			  `install_plan_id` int(11) NULL,
			  `membership_amount` double NULL,
			  `membership_class` varchar(255) NULL,
			  `installment_amount` double NULL,
			  `signup_fee` double NULL,
			  `gmgt_membershipimage` varchar(255) NULL,
			  `created_date` date NULL,
			  `created_by_id` int(11) NULL,
			  `membership_description` text NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);						
				
		$sql="CREATE TABLE IF NOT EXISTS `membership_activity` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `activity_id` int(11) NULL,
			  `membership_id` int(11) NULL,
			  `created_by` int(11) NULL,
			  `created_date` date NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);							
				
		$sql="CREATE TABLE IF NOT EXISTS `membership_history` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `member_id` int(11) NULL,
			  `selected_membership` int(11) NULL,
			  `assign_staff_mem` int(11) NULL,
			  `intrested_area` int(11) NULL,
			  `g_source` int(11) NULL,
			  `referrer_by` int(11) NULL,
			  `inquiry_date` date NULL,
			  `trial_end_date` date NULL,
			  `membership_valid_from` date NULL,
			  `membership_valid_to` date NULL,
			  `first_pay_date` date NULL,
			  `created_date` date NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);											
				
		$sql="CREATE TABLE IF NOT EXISTS `membership_payment` (
			  `mp_id` int(11) NOT NULL AUTO_INCREMENT,
			  `member_id` int(11) NULL,
			  `membership_id` int(11) NULL,
			  `membership_amount` double NULL,
			  `paid_amount` double NULL,
			  `start_date` date NULL,
			  `end_date` date NULL,
			  `membership_status` varchar(50) NULL,
			  `payment_status` varchar(20) NULL,
			  `created_date` date NULL,
			  `created_by` int(11) NULL,
			  PRIMARY KEY (`mp_id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);												
				
		$sql="CREATE TABLE IF NOT EXISTS `membership_payment_history` (
			  `payment_history_id` bigint(20) NOT NULL AUTO_INCREMENT,
			  `mp_id` int(11) NULL,
			  `amount` int(11) NULL,
			  `payment_method` varchar(50) NULL,
			  `paid_by_date` date NULL,
			  `created_by` int(11) NULL,
			  `trasaction_id` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`payment_history_id`)
				)DEFAULT CHARSET=utf8";
													
		$stmt = $conn->execute($sql);	
				
		$sql="CREATE TABLE IF NOT EXISTS `specialization` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(100) NULL,
			  PRIMARY KEY (`id`)
				)DEFAULT CHARSET=utf8";

		$stmt = $conn->execute($sql);	
		
		file_put_contents(TMP.'installed.txt', date('Y-m-d, H:i:s'));	
		
		$this->redirect(["action"=>"success"]);
		
	}
	
	private function insertData($data)
	{
		$this->viewBuilder()->layout("");
		$this->autoRender = false;
		$year = date("Y");
		$conn = ConnectionManager::get('install_db');
		$sql = $insert = "INSERT INTO `general_setting` (`name`, `start_year`, `address`, `office_number`, `country`, `email`, `date_format`, `calendar_lang`, `gym_logo`, `cover_image`, `weight`, `height`, `chest`, `waist`, `thing`, `arms`, `fat`, `member_can_view_other`, `staff_can_view_own_member`, `enable_sandbox`, `paypal_email`, `currency`, `enable_alert`, `reminder_days`, `reminder_message`, `enable_message`, `left_header`, `footer`,`system_installed`) VALUES
			('{$data['name']}', '{$year}', 'address', '8899665544', '{$data['country']}','{$data['email']}', '{$data['date_format']}', '{$data['calendar_lang']}', '', '', 'KG', 'Centimeter', 'Inches', 'Inches', 'Inches', 'Inches', 'Percentage', 0, 1, 0, 'your_id@paypal.com', '{$data['currency']}', 1, '5', 'Hello GYM_MEMBERNAME,\r\n      Your Membership  GYM_MEMBERSHIP  started at GYM_STARTDATE and it will expire on GYM_ENDDATE.\r\nThank You.', 1,'GYM MASTER','Copyright © 2016-2017. All rights reserved.',1)";
		$stmt = $conn->execute($sql);		
		
		
		$sql = "INSERT INTO `category` (`name`) VALUES
				('Regular'),
				('Limited'),
				('Total Gym Exercises for Abs (Abdomininals)'),
				('Total Gym Exercises for Legs'),
				('Total Gym Exercises for Biceps'),
				('Exercise')";
		$stmt = $conn->execute($sql);
		
		$sql = "INSERT INTO `activity` (`cat_id`, `title`, `assigned_to`, `created_by`, `created_date`) VALUES
				( 5, 'Hyperextension', 2, 1, '2016-08-22'),
				(3, 'Crunch', 2, 1, '2016-08-22'),
				(4, 'Leg curl', 2, 1, '2016-08-22'),
				(4, 'Reverse Leg Curl', 2, 1, '2016-08-22'),
				(6, 'Body Conditioning', 2, 1, '2016-10-19'),
				(6, 'Free Weights', 2, 1, '2016-10-19'),
				(3, 'Fixed Weights', 2, 1, '2016-10-19'),
				(3, 'Resisted Crunch', 2, 1, '2016-10-19'),
				(6, 'Plank', 2, 1, '2016-10-19'),
				(4, 'High Leg Pull-In', 2, 1, '2016-10-19'),
				(4, 'Low Leg Pull-In', 2, 1, '2016-10-19')";
		$stmt = $conn->execute($sql);
		
		$sql = "INSERT INTO `installment_plan` (`number`, `duration`) VALUES
				(1, 'Month'),
				(1, 'Week'),
				(1, 'Year')";
		$stmt = $conn->execute($sql);
		
		$sql = "INSERT INTO `gym_roles` (`name`) VALUES
				('Yoga')";
		$stmt = $conn->execute($sql);
		
		$sql = "INSERT INTO `class_schedule` (`class_name`, `assign_staff_mem`, `assistant_staff_member`, `location`, `days`, `start_time`, `end_time`, `created_by`, `created_date`) VALUES
				('Yoga Class', 2, 0, 'At Gym Facility', \"['Sunday','Saturday']\", '8:00:AM', '10:00:AM', 1, '2016-08-22'),
				('Aerobics Class', 2, 0, 'Class 1', \"['Sunday','Friday','Saturday']\", '5:15:PM', '6:15:PM', 1, '2016-08-22'),
				('HIT Class', 2, 2, 'Old location', \"['Sunday','Tuesday','Thursday']\", '7:30:PM', '8:45:PM', 1, '2016-08-22'),
				('Cardio Class', 2, 0, 'At Gym Facility', \"['Friday','Saturday']\", '3:30:PM', '4:30:PM', 1, '2016-08-22'),
				('Pilates', 2, 0, 'Old location', \"['Sunday']\", '12:00:PM', '3:15:PM', 1, '2016-08-22'),
				('Zumba Class',2, 0, 'New Location', \"['Saturday']\", '8:30:PM', '10:30:PM', 1, '2016-08-22'),
				('Power Yoga Class', 2, 0, 'New Location', \"['Monday','Wednesday','Thursday','Friday','Saturday']\", '9:15:AM', '11:45:AM', 1, '2016-08-22')";
		$stmt = $conn->execute($sql);
		
		$sql = "INSERT INTO `membership` (`membership_label`, `membership_cat_id`, `membership_length`, `membership_class_limit`, `limit_days`, `limitation`, `install_plan_id`, `membership_amount`, `membership_class`, `installment_amount`, `signup_fee`, `gmgt_membershipimage`, `created_date`, `created_by_id`, `membership_description`) VALUES
				('Platinum Membership', 1, 360, 'Unlimited', 0, '', 1, 500, \"['1','2','3','4','5','6','7']\", 42, 5, '', '2016-08-22', 1, '<p>Platinum membership description<br></p>'),
				('Gold Membership', 1, 300, 'Unlimited', 0, '', 1, 450, \"['1','2','3','4','5']\", 37, 5, '', '2016-08-22', 1, '<p>Gold membership description<br></p>'),
				('Silver Membership', 2, 180, 'Limited', 0, 'per_week', 2, 200, \"['4','6','7']\", 5, 5, '', '2016-08-22', 1, '<p>Silver &nbsp;membership description</p>')";
		$stmt = $conn->execute($sql);	
		$this->updateSys();
	}
	
	
	public function updateSys()
	{		
		$this->autoRender = false;
		
		$conn = ConnectionManager::get('install_db');
		$sql = "SELECT * from general_setting";
		$settings = $conn->execute($sql)->fetchAll("assoc");
		if(!empty($settings))
		{
			if(isset($settings[0]["system_version"]))
			{
				$version = $settings[0]["system_version"];
				switch($version)
				{
					CASE "2": /* If old version is 2*/
					
						/* update queries for version 3 */
						
					break ;
					
					CASE "9":
					$sql = "ALTER TABLE `general_setting` ADD `time_zone` VARCHAR(20) NOT NULL DEFAULT 'UTC' AFTER `datepicker_lang`";
					$conn->execute($sql);
					break ;
				}
				
			}
			else
			{
				/* 1st Update */		
				$sql = "ALTER TABLE `general_setting` ADD `enable_rtl` INT(11) NULL DEFAULT '0'";
				$conn->execute($sql);
				$sql = "ALTER TABLE `general_setting` CHANGE `enable_rtl` `enable_rtl` INT(11) NULL DEFAULT '0'";
				$conn->execute($sql);
				$sql = "ALTER TABLE `general_setting` ADD `datepicker_lang` TEXT NULL DEFAULT NULL";
				$conn->execute($sql);
				$sql = "ALTER TABLE `general_setting` ADD `system_version` TEXT NULL DEFAULT NULL";
				$conn->execute($sql);
				$sql = "ALTER TABLE `general_setting` ADD `sys_language` VARCHAR(20) NOT NULL DEFAULT 'en'";
				$conn->execute($sql);
				/* $sql = "UPDATE `general_setting` SET system_version = '2'"; */
				$sql = "UPDATE `general_setting` SET system_version = '11'";
				$conn->execute($sql);
				
				$sql = "UPDATE `general_setting` SET datepicker_lang = 'en'";
				$conn->execute($sql);				
								
				$path = $this->request->base;
				$sql = "INSERT INTO `gym_accessright` (`controller`, `action`, `menu`, `menu_icon`, `menu_title`, `member`, `staff_member`, `accountant`, `page_link`) VALUES ('Reports', '', 'report', 'report.png', 'Report', '0', '1', '1', '".$path."/reports/membership-report')";
				$conn->execute($sql);
				
				$sql = "ALTER TABLE `general_setting` ADD `time_zone` VARCHAR(20) NOT NULL DEFAULT 'UTC' AFTER `datepicker_lang`";
				$conn->execute($sql);
				
				$sql = "SHOW COLUMNS FROM `membership` LIKE 'membership_class' ";
				$columns = $conn->execute($sql)->fetch();
				if($columns == false)
				{
					$sql = "ALTER TABLE `membership` ADD `membership_class` varchar(255) NULL";
					$conn->execute($sql);
				}						
			}				
		}		
	}
	
	
	public function success()
	{
		
	}
	
	public function isAuthorized($user)
	{
		return true;
	}
}