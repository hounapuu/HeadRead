<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Example payment usage - Swedbank - pangalink.net</title>
    </head>
    <body>
<?php

// THIS IS AUTO GENERATED SCRIPT
// (c) 2011-2018 Kreata OÜ www.pangalink.net

// File encoding: UTF-8
// Check that your editor is set to use UTF-8 before using any non-ascii characters

// STEP 1. Setup private key
// =========================

$private_key = openssl_pkey_get_private(
"-----BEGIN RSA PRIVATE KEY-----
MIIEpQIBAAKCAQEA5eLI+ogemvp2NKVyzSBAv1eoKjsff94mIt+fhgkR7tmXzN1Q
D+IzT9CGCVLyE6mJrb+xhUl2F1qTSza55TH4Yk8lqwyxP9za80qvS0LNU+Nz4ciw
VOO9dXs+HhZgJrMNDAD43RXySGCmskjvlre3/Xlg8CKl9rXFBEqPTYjJB8rYrAJA
7z45VQ+/X75qyDeGcQYiyr0MlLrGmfdSQru4N9YVDlN343EOh9bNDuPA33TZNDVn
9MbOXVwO6ckqO6I0TTxjjYZijlU9o+eNdjgkcdc5UYCpB2268rQx+TMK9pSCBaF+
q9FRPet8MP/5C1ANIJkjFRy0vGWZZKED1dAOjQIDAQABAoIBABzOMgjSjaM1xyIJ
qTzy0aooPbYs+mF3YKf2BXMyJ8EaGt9cy+9xlKRnqKP6dMLp94qB/qiI7/c1Lke6
b8i8XjdTW5D3Yi5yai0aKqTvlfLxCVA9aXr5nn/eFYaHnzy6KuRaKtTpLxbKpZip
cvwbwT5Nu0vby5gCZtGG1jYM8cO79mYVvTBzzJ0yEK/gxogv95ou7I9Wxg3x3/Mc
iFdD6kssLYh5JWLbLf3Hshs3nQn9uy+ZViEk+npmDf4gKeZ3IsaEKkQZZyMff7z/
YLc5lDwm6ECGWeEHK8ISAQyg7NRKKFjCxnQsA2Wn8JMmZePf9hRaWQhxhat4jY2D
V/kwAgECgYEA9Lt2PmPd8qSJAMafFKXfUdq0VYjSVF/zCxgG8BzjLGtDd+FrciDt
jQL1g57auHeFg8OfyAhnwGKKT/hy+fVa90khzBcfC7EaPJq4MFPVGNg+JR/0iq3Y
OO6tdY2047Pf79oUQ7Cx8S+jC1aQnqZc8OE2npeo985qLufkRVEsny0CgYEA8HhW
ChUiROmtl0Ip/DLZ5Ta5Vpn5BB+Vi7fqygaKEGECEd7DbcF/nSvrZAgcOlvgtSod
fS49BkSfW04q6xx5E/CPSEXIYFMcPV+AfLnSCoxoL4UDIL0O79V1vhVkK9YgiZmP
f9iBRlEECcImv3ObI5hHikODgirDpSeK0dRRyOECgYEAjGiBDop9bBi6AZfy7QW9
eljf3bMB+SaTamn+kQQB0ho4Oy85VeFOaPipozoggnUQROiXY0xvOhFPCVKhpIcA
CaALo+wgA7U4OE0MH635NKfb/7C1vFrBEujc2/TRM1KfyBx2Q9+8N4P9JyQjFOKd
sBWGILciWgozIXYpoRtRXoECgYEAtNZ6Ncjg5Zwp/Hc4Zb3EGVkHFjZiixRJfTIJ
cnZqe5jIWrIAm9iJZKQzuB1VRRn1KaiLVqlgIQeYI6zsH7Vg5Hri9cHsx2uY8BqS
4LlJWL9wVlQcHxGuWvRXQGSL2V+FRpVh0g36YevpMoF8bDu/LoyFOFg/XLNWQCw1
fEjEXGECgYEApZQ85WkrRQgr4llsgM4xkkaoi7X3C/5Y2oUVU3kWeqIrQ7dg1Coh
TEnSzgAPyqVpzEdCHOXXAhtBle7kypY0msBL+Mx0/PTfdC0EMPo7CKa2JuQAz20S
C/HYqTN7U/8N/dCPUVGub7+iE1SAihiknbWi8Bvivww/ehnSs6INTYU=
-----END RSA PRIVATE KEY-----");

// STEP 2. Define payment information
// ==================================

$fields = array(
        "VK_SERVICE"     => "1011",
        "VK_VERSION"     => "008",
        "VK_SND_ID"      => "uid13",
        "VK_STAMP"       => "12345",
        "VK_AMOUNT"      => "5",
        "VK_CURR"        => "EUR",
        "VK_ACC"         => "EE152200221234567897",
        "VK_NAME"        => "HeadRead VRL",
        "VK_REF"         => "1234561",
        "VK_LANG"        => "EST",
        "VK_MSG"         => "Annetus",
        "VK_RETURN"      => "http://localhost:3480/project/5abfd309768f38312c62487d?payment_action=success",
        "VK_CANCEL"      => "http://localhost:3480/project/5abfd309768f38312c62487d?payment_action=cancel",
        "VK_DATETIME"    => "2018-03-31T21:28:03+0300",
        "VK_ENCODING"    => "utf-8",
);

// STEP 3. Generate data to be signed
// ==================================

// Data to be signed is in the form of XXXYYYYY where XXX is 3 char
// zero padded length of the value and YYY the value itself
// NB! Swedbank expects symbol count, not byte count with UTF-8,
// so use `mb_strlen` instead of `strlen` to detect the length of a string

$data = str_pad (mb_strlen($fields["VK_SERVICE"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_SERVICE"] .    /* 1011 */
        str_pad (mb_strlen($fields["VK_VERSION"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_VERSION"] .    /* 008 */
        str_pad (mb_strlen($fields["VK_SND_ID"], "UTF-8"),  3, "0", STR_PAD_LEFT) . $fields["VK_SND_ID"] .     /* uid13 */
        str_pad (mb_strlen($fields["VK_STAMP"], "UTF-8"),   3, "0", STR_PAD_LEFT) . $fields["VK_STAMP"] .      /* 12345 */
        str_pad (mb_strlen($fields["VK_AMOUNT"], "UTF-8"),  3, "0", STR_PAD_LEFT) . $fields["VK_AMOUNT"] .     /* 150 */
        str_pad (mb_strlen($fields["VK_CURR"], "UTF-8"),    3, "0", STR_PAD_LEFT) . $fields["VK_CURR"] .       /* EUR */
        str_pad (mb_strlen($fields["VK_ACC"], "UTF-8"),     3, "0", STR_PAD_LEFT) . $fields["VK_ACC"] .        /* EE152200221234567897 */
        str_pad (mb_strlen($fields["VK_NAME"], "UTF-8"),    3, "0", STR_PAD_LEFT) . $fields["VK_NAME"] .       /* HeadRead TÜK */
        str_pad (mb_strlen($fields["VK_REF"], "UTF-8"),     3, "0", STR_PAD_LEFT) . $fields["VK_REF"] .        /* 1234561 */
        str_pad (mb_strlen($fields["VK_MSG"], "UTF-8"),     3, "0", STR_PAD_LEFT) . $fields["VK_MSG"] .        /* Torso Tiger */
        str_pad (mb_strlen($fields["VK_RETURN"], "UTF-8"),  3, "0", STR_PAD_LEFT) . $fields["VK_RETURN"] .     /* http://localhost:3480/project/5abfd309768f38312c62487d?payment_action=success */
        str_pad (mb_strlen($fields["VK_CANCEL"], "UTF-8"),  3, "0", STR_PAD_LEFT) . $fields["VK_CANCEL"] .     /* http://localhost:3480/project/5abfd309768f38312c62487d?payment_action=cancel */
        str_pad (mb_strlen($fields["VK_DATETIME"], "UTF-8"), 3, "0", STR_PAD_LEFT) . $fields["VK_DATETIME"];    /* 2018-03-31T21:28:03+0300 */

/* $data = "0041011003008005uid1300512345003150003EUR020EE152200221234567897012HeadRead TÜK0071234561011Torso Tiger077http://localhost:3480/project/5abfd309768f38312c62487d?payment_action=success076http://localhost:3480/project/5abfd309768f38312c62487d?payment_action=cancel0242018-03-31T21:28:03+0300"; */

// STEP 4. Sign the data with RSA-SHA1 to generate MAC code
// ========================================================

openssl_sign ($data, $signature, $private_key, OPENSSL_ALGO_SHA1);

/* I6YdfoGaI0GBKY3V49ND8AjZQLtmaohTRz/krfwT81GNizwTNOQele8EPU5z8v+V6LwrNmNO79sU6pRj2IFhxt7sbruCExYuy/sO9di0AhzpIAigEdYLAFZGILI2POKPr25x59rdKXmLzyxX0UQ/abrzNR+exJIaBhbcfHtYgTAvrlCbb1M5albWVkxF3A1IWg9hd8lZKyCyyNdupLJyzWyrKtwoHgWxt7hP9RRij77n8elsYSnvSLAQUKdOe739PsQOVIvz0EiLiFHHV63nzGaW5dRsaGuoQSuCbtT4TmrsUfr+6sJT8JSzYG1EIExBzaj9fM0VQy7J4pYx8+/fyQ== */
$fields["VK_MAC"] = base64_encode($signature);

// STEP 5. Generate POST form with payment data that will be sent to the bank
// ==========================================================================
?>

        <h1><a href="http://localhost:3480/">Pangalink.net</a></h1>
        <p>Makse teostamise näidisrakendus <strong>"Swedbank"</strong></p>

        <form method="post" action="http://localhost:3480/banklink/swedbank">
            <!-- include all values as hidden form fields -->
<?php foreach($fields as $key => $val):?>
            <input type="hidden" name="<?php echo $key; ?>" value="<?php echo htmlspecialchars($val); ?>" />
<?php endforeach; ?>

            <!-- draw table output for demo -->
            <table>
<?php foreach($fields as $key => $val):?>
                <tr>
                    <td><strong><code><?php echo $key; ?></code></strong></td>
                    <td><code><?php echo htmlspecialchars($val); ?></code></td>
                </tr>
<?php endforeach; ?>

                <!-- when the user clicks "Edasi panga lehele" form data is sent to the bank -->
                <tr><td colspan="2"><input type="submit" value="Edasi panga lehele" /></td></tr>
            </table>
        </form>

    </body>
</html>
