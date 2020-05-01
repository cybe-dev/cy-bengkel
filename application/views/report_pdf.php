<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-size: 16px;
        }
        h1 {
            text-align:center;
            text-decoration: underline;
            font-size: 26px;
        }

        .table {
            margin-top: 32px;
            border-collapse: collapse;
        }

        .table th,td {
            border:1px solid #000;
            padding: 7px 9px;
        }
    </style>
</head>
<body>
    <h1><?=strtoupper("laporan penjualan ".$type);?></h1>
    <div style="text-align:center"><?=$subtitle;?></div>

    <table width="100%" class="table">
        <thead>
            <tr>
            <?php
            if($type == "sparepart") {
            ?>

                <th>#</th>
                <th>Tanggal</th>
                <th>Items</th>
                <th>Total</th>

            <?php } else { ?>

                <th>#</th>
                <th>Customer</th>
                <th>Plat</th>
                <th>Tanggal</th>
                <th>Total</th>

            <?php } ?>

            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            $grand_total = 0;
            foreach($fetch as $row) {
                $i++;
                $grand_total = $grand_total + $row->total;
                if($type == "sparepart") {
            ?>

                <tr>
                    <td style="text-align:center"><?=$i;?></td>
                    <td style="text-align:center"><?=$row->date;?></td>
                    <td style="text-align:center"><?=$row->items;?></td>
                    <td style="text-align:center"><?=rupiah($row->total);?></td>
                </tr>

            <?php
                } else {
            ?>

                <tr>
                    <td style="text-align:center"><?=$i;?></td>
                    <td><?=$row->customer;?></td>
                    <td style="text-align:center"><?=$row->plat;?></td>
                    <td style="text-align:center"><?=$row->date;?></td>
                    <td style="text-align:center"><?=rupiah($row->total);?></td>
                </tr>

            <?php
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="<?php if($type == "sparepart") { echo '3'; } else {echo '4';} ?>">Total</td>
                <td style="text-align:center"><?=rupiah($grand_total);?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>