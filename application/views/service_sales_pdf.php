<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Service Sales PDF</title>

    <style>
        body {
            font-size: 16px;
        }
        .header {
            background: "#CCC";
        }
        .heading {
            float:left;
            width: 50%;
        }

        .heading h1 {
            font-size: 24px;
            margin:0;
            padding:0;
        }
        
        .heading h2 {
            font-size: 16px;
            margin: 9px 0;
        }

        .title {
            float:right;
            border: 1px solid #000;
            padding: 9px 22px;
        }
        .header:after {
            display:block;
            content: "";
            clear: both;
        }

        .no-td {
            border:none;
            padding: 0;
        }

        .label {
            padding: 0 9px 0 16px;
        }

        .col-wrap:after {
            clear:both;
            display:block;
            content: "";
        }

        .col-1 {
            float:left;
        }

        .col-2 {
            float:right;
        }

        table {
            border-collapse: collapse;
        }

        table th,td {
            border:1px solid #000;
            padding: 7px 9px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="heading">
            <?php
            //convert image into Binary data
            $img_type = "png";
            $img_data = fopen ( "././img/logo.png", 'rb' );
            $img_size = filesize ( "././img/logo.png" );
            $binary_image = fread ( $img_data, $img_size );
            fclose ( $img_data );

            //Build the src string to place inside your img tag
            $img_src = "data:image/".$img_type.";base64,".str_replace ("\n", "", base64_encode ( $binary_image ) );
            ?>
            <img src="<?=$img_src;?>" style="max-width:100px;float:left">
            <div style="padding: 0 0 0 112px">
                <h1><?=$this->shop_info->get_shop_name();?></h1>
                <h2><?=$this->shop_info->get_shop_address();?></h2>
            </div>
        </div>
        <span class="title">Nota Service</span>
    </div>

    <div class="col-wrap" style="margin-top: 22px">
        <div class="col-1">
            <table>
                <tr>
                    <td class="no-td">Nama Customer</td>
                    <td class="no-td label">:</td>
                    <td class="no-td"><?=$fetch->customer;?></td>
                </tr>
                <tr>
                    <td class="no-td">No. Plat</td>
                    <td class="no-td label">:</td>
                    <td class="no-td"><?=$fetch->plat;?></td>
                </tr>
            </table>
        </div>
        <div class="col-2">
            <table>
                <tr>
                    <td class="no-td">Tanggal</td>
                    <td class="no-td label">:</td>
                    <td class="no-td"><?=date("d/m/Y",strtotime($fetch->date));?></td>
                </tr>
            </table>
        </div>
    </div>

    <table width="100%" style="margin-top: 12px">
        <thead>
            <tr>
                <th width="45%">Item</th>
                <th>Banyaknya</th>
                <th>Harga</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($details as $detail) {
        ?>

            <tr>
                <td><?=$detail->name;?></td>
                <td style="text-align:center"><?=$detail->qty;?></td>
                <td style="text-align:right"><?=rupiah($detail->price);?></td>
                <td style="text-align:right"><?=rupiah($detail->price * $detail->qty);?></td>
            </tr>

        <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align:right;border:none">Total : </td>
                <td style="text-align:right"><?=rupiah($fetch->total);?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>