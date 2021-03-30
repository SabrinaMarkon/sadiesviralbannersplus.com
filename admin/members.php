<?php
# Prevent direct access to this file. Show browser's default 404 error instead.
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit;
}

require "control.php";
if (isset($show)) {
    echo $show;
}
$allmembers = new Member();
$members = $allmembers->getAllMembers();
?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">

            <h1 class="ja-bottompadding">Add New Member</h1>

            <form action="/admin/members" method="post" accept-charset="utf-8" class="form" role="form">

                <label sr-only for="username" class="mt-1">Username:</label>
                <input type="text" name="username" value="" class="form-control input-lg" placeholder="Username" required>

                <label sr-only for="password" class="mt-1">Password:</label>
                <input type="password" name="password" id="password" value="" class="form-control input-lg" placeholder="Password" required>

                <label sr-only for="accounttype" class="mt-1">Membership Type:</label>
                <select name="accounttype" class="form-control widetableselect">
                    <option value="Free">Free</option>
                    <option value="Pro">Pro</option>
                    <option value="Gold">Gold</option>
                </select>

                <div class="row">
                    <div class="col-xs-6 col-md-6">
                        <label sr-only for="firstname">First Name:</label>
                        <input type="text" name="firstname" value="" class="form-control input-lg" placeholder="First Name" required>
                    </div>
                    <div class="col-xs-6 col-md-6">
                        <label sr-only for="lastname">Last Name:</label>
                        <input type="text" name="lastname" value="" class="form-control input-lg" placeholder="Last Name" required>
                    </div>
                </div>

                <label sr-only for="email" class="mt-1">Email:</label>
                <input type="email" name="email" value="" class="form-control input-lg" placeholder="Your Email" required>

                <label sr-only for="confirm_password" class="mt-1">Confirm Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" value="" class="form-control input-lg" placeholder="Confirm Password" required>

                <label for="paypal" class="mt-1">Paypal Email:</label>
                <input type="email" name="paypal" value="" class="form-control input-lg" placeholder="Paypal Email">

                <label for="bitcoin" class="mt-1">Bitcoin Wallet ID:</label>
                <input type="text" name="bitcoin" value="" class="form-control input-lg" placeholder="Bitcoin Wallet ID">

                <label sr-only for="country" class="mt-1">Country:</label>
                <select name="country" class="form-control input-lg">
                    <option value="Canada">Canada</option>
                    <option value="United States">United States</option>
                    <?php
                    $country = '';
                    $countrylist = new Countries();
                    echo $countrylist->showCountries($country);
                    ?>
                </select>

                <label sr-only for="referid" class="mt-1">Sponsor:</label>
                <select name="referid" class="form-control input-lg">
                    <option value="admin">admin</option>
                    <?php
                    foreach ($members as $member) {
                        $referid = $member['username'];
                    ?>
                        <option value="<?php echo $referid ?>"><?php echo $referid ?></options>
                        <?php
                    }
                        ?>
                </select>

                <div class="ja-bottompadding"></div>

                <button class="btn btn-lg btn-primary ja-toppadding ja-bottompadding" type="submit" name="adminaddmember">Create Account</button>

            </form>

            <div class="ja-bottompadding"></div>

            <h1 class="ja-bottompadding">Website Members</h1>

        </div>
    </div>
</div>

<div class="mt-4">
    <table id="admintable" class="table table-condensed table-bordered table-striped table-hover text-center table-sm">
        <thead>
            <tr>
                <th class="text-center small">#</th>
                <th class="text-center small">Username</th>
                <th class="text-center small">Password</th>
                <th class="text-center small">Membership</th>
                <th class="text-center small">First&nbsp;Name</th>
                <th class="text-center small">Last&nbsp;Name</th>
                <th class="text-center small">Email&nbsp;Address</th>
                <th class="text-center small">Verified</th>
                <th class="text-center small">Paypal</th>
                <th class="text-center small">Bitcoin</th>
                <th class="text-center small">Country</th>
                <th class="text-center small">Signup&nbsp;Date</th>
                <th class="text-center small">Signup&nbsp;IP</th>
                <th class="text-center small">Last&nbsp;Login</th>
                <th class="text-center small">Sponsor</th>
                <th class="text-center small">Commission Owed</th>
                <th class="text-center small">Commission Paid</th>
                <th class="text-center small">Edit</th>
                <th class="text-center small">Login</th>
                <th class="text-center small">Delete</th>
            </tr>
        </thead>
        <tbody>

            <?php
            foreach ($members as $member) {

                $signupdate = new DateTime($member['signupdate']);
                $datesignedup = $signupdate->format('Y-m-d');

                if ($member['verified'] === '') {
                    $verified = 'Not Yet';
                } else {
                    $verified = date('Y-m-d');
                }

                $lastlogin = new DateTime($member['lastlogin']);
                if ($member['lastlogin'] === NULL) {
                    $datelastlogin = 'Not Yet';
                } else {
                    $datelastlogin = $lastlogin->format('Y-m-d');
                }
            ?>
                <tr>
                    <form action="/admin/members/<?php echo $member['id']; ?>" method="post" accept-charset="utf-8" class="form" role="form">
                        <td class="small">
                            <?php echo $member['id']; ?>
                        </td>
                        <td>
                            <input type="text" name="username" value="<?php echo $member['username']; ?>" class="form-control input-sm widetableinput" placeholder="Username" required>
                        </td>
                        <td>
                            <input type="text" name="password" value="<?php echo $member['password']; ?>" class="form-control input-sm widetableinput" placeholder="Password" required>
                        </td>
                        <td>
                            <select name="accounttype" class="form-control widetableselect">
                                <option value="Free" <?php if ($member['accounttype'] === "Free") {
                                                            echo " selected";
                                                        } ?>>Free</option>
                                <option value="Pro" <?php if ($member['accounttype'] === "Pro") {
                                                        echo " selected";
                                                    } ?>>Pro</option>
                                <option value="Gold" <?php if ($member['accounttype'] === "Gold") {
                                                            echo " selected";
                                                        } ?>>Gold</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="firstname" value="<?php echo $member['firstname']; ?>" class="form-control input-sm widetableinput" placeholder="First Name" required>
                        </td>
                        <td>
                            <input type="text" name="lastname" value="<?php echo $member['lastname']; ?>" class="form-control input-sm widetableinput" placeholder="Last Name" required>
                        </td>
                        <td>
                            <input type="email" name="email" value="<?php echo $member['email']; ?>" class="form-control input-sm widetableinput" placeholder="Email" required>
                        </td>
                        <td class="small">
                            <?php echo $verified ?>
                        </td>
                        <td>
                            <input type="email" name="paypal" value="<?php echo $member['paypal']; ?>" class="form-control input-sm widetableinput" placeholder="Paypal">
                        </td>
                        <td>
                            <input type="text" name="bitcoin" value="<?php echo $member['bitcoin']; ?>" class="form-control input-sm widetableinput" placeholder="Bitcoin Wallet ID">
                        </td>
                        <td>
                            <select name="country" class="form-control widetableselect">
                                <option value="Canada" <?php if ($member['country'] === "Canada") {
                                                            echo " selected";
                                                        } ?>>Canada</option>
                                <option value="United States" <?php if ($member['country'] == "United States") {
                                                                    echo " selected";
                                                                } ?>>United States</option>
                                <?php
                                $countrylist = new Countries();
                                echo $countrylist->showCountries($member['country']);
                                ?>
                            </select>
                        </td>
                        <td class="small">
                            <?php echo $datesignedup ?>
                        </td>
                        <td>
                            <input type="text" name="signupip" value="<?php echo $member['signupip']; ?>" class="form-control input-sm widetableinput" placeholder="IP" required>
                        </td>
                        <td class="small">
                            <?php echo $datelastlogin ?>
                        </td>
                        <td>
                            <select name="referid" class="form-control input-sm widetableselect">
                                <option value="admin" <?php if ($member['referid'] === 'admin') {
                                                            echo "selected";
                                                        } ?>>admin</option>
                                <?php
                                foreach ($members as $sponsor) {
                                    $referid = $sponsor['username'];
                                ?>
                                    <option value="<?php echo $referid ?>" <?php if ($member['referid'] === $referid) {
                                                                                echo "selected";
                                                                            } ?>><?php echo $referid ?></options>
                                    <?php
                                }
                                    ?>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="owed" value="<?php echo $member['owed']; ?>" class="form-control input-sm widetableinput" placeholder="0.00" required>
                        </td>
                        <td>
                            <input type="text" name="paid" value="<?php echo $member['paid']; ?>" class="form-control input-sm widetableinput" placeholder="0.00" required>
                        </td>
                        <td>
                            <input type="hidden" name="_method" value="PATCH">
                            <button class="btn btn-sm btn-primary" type="submit" name="adminsavemember">SAVE</button>
                        </td>
                    </form>
                    <td>
                        <form action="../members" method="POST" target="_blank" accept-charset="utf-8" class="form" role="form">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="username" value="<?php echo $member['username']; ?>">
                            <input type="hidden" name="password" value="<?php echo $member['password']; ?>">
                            <button class="btn btn-sm btn-primary" type="submit" name="login">LOGIN</button>
                    </td>
                    </form>
                    <td>
                        <form action="/admin/members/<?php echo $member['id']; ?>" method="POST" accept-charset="utf-8" class="form" role="form">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="username" value="<?php echo $member['username']; ?>">
                            <button class="btn btn-sm btn-primary" type="submit" name="admindeletemember">DELETE</button>
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>
</div>

<div class="ja-bottompadding"></div>
