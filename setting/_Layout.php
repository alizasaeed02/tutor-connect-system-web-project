<!DOCTYPE html>
<html lang="en">

	<head>
		<?php include '../setting/_Head.php'; ?>
	</head>

	<body>

		<!-- Page wrapper start -->
		<div class="page-wrapper">

			<!-- Main container start -->
			<div class="main-container">

				<!-- Sidebar wrapper start -->
				<?php include '../setting/_Sidebar.php'; ?>
				<!-- Sidebar wrapper end -->

				<!-- App container starts -->
				<div class="app-container">

					<!-- App header starts -->
					<?php include '../setting/_Header.php'; ?>
					<!-- App header ends -->

					<!-- App hero header starts -->
					<?php include '../setting/_Hero_Header.php'; ?>
					<!-- App Hero header ends -->

					<!-- App body starts -->
					<div class="app-body">
						<?php 
							$message = '';
							$message_class = '';
						
							if (isset($_SESSION['message']) && isset($_SESSION['message_class'])) {
								$message = $_SESSION['message'];
								$message_class = $_SESSION['message_class'];
								unset($_SESSION['message']);
								unset($_SESSION['message_class']);
							}
						?>
						<?php if ($message): ?>
							<div class="alert <?php echo $message_class; ?> alert-dismissible fade show" role="alert">
								<strong style="text-transform: uppercase;"><?php echo $message_class; ?>!</strong> <?php echo $message; ?>
  								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						<?php endif; ?>
						
                        <?php include $content; ?>

					</div>
					<!-- App body ends -->

					<!-- App footer start -->
					<?php include '../setting/_Footer.php'; ?>
					<!-- App footer end -->

				</div>
				<!-- App container ends -->

			</div>
			<!-- Main container end -->

		</div>
		<!-- Page wrapper end -->

		<!-- *************
			************ JavaScript Files *************
		************* -->
		<?php include '../setting/_JS_Footer_Files.php'; ?>
	</body>

</html>