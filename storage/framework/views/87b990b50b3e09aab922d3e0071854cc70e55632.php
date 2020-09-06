<?php if(Auth::guard('admin')->check()): ?>
<div class="user-account">
                <div class="user_div">
                    <?php if(Auth::guard('admin')->User()->picture == NULL): ?>
                    <img src="<?php echo e(asset('assets/images/user.png')); ?>" class="user-photo" alt="User Profile Picture">
                    <?php else: ?>
                    <img src="<?php echo e(Auth::guard('admin')->User()->picture); ?>" class="user-photo" alt="User Profile Picture">
                    <?php endif; ?>
                </div>
                <div class="dropdown">
                    <span>Welcome,</span>
                    <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong><?php echo e(Auth::guard('admin')->User()->name); ?></strong></a>
                    <ul class="dropdown-menu dropdown-menu-right account vivify flipInY">
                        <li><a href="profile.html"><i class="icon-user"></i>My Profile</a></li>
                        <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>
                        <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="page-login.html"><i class="icon-power"></i>Logout</a></li>
                    </ul>
                </div>                
        </div>  
<?php endif; ?>            <?php /**PATH C:\xampp\htdocs\Admin\resources\views/layouts/info.blade.php ENDPATH**/ ?>