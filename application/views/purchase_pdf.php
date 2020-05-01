<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase_pdf</title>

    <style>
        body {
            font-size: 16px;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .header h1 {
            text-decoration: underline;
            font-size: 22px;
        }

        .table {
            margin-top: 18px;
            border-collapse: collapse;
        }

        .table tr,td,th {
            border: 1px solid #000;
            padding: 3px 9px
        }

    </style>
</head>
<body>
    <div class="header">
        <h1>PEMBELIAN STOCK SPAREPART</h1>
    </div>

    <table width="100%" style="margin-top: 24px">
        <tr>
            <td width="50%" valign="top" style="border:none;padding:0">
                <table>
                    <tr>
                        <td style="border:none;padding: 0 9px 3px 0" valign="top">Supplier</td>
                        <td style="border:none;padding: 0 9px 3px 0" valign="top">:</td>
                        <td style="border:none;padding: 0 9px 3px 0" valign="top"><?=$fetch->name;?></td>
                    </tr>
                    <tr>
                        <td style="border:none;padding: 0 9px 3px 0" valign="top">Alamat</td>
                        <td style="border:none;padding: 0 9px 3px 0" valign="top">:</td>
                        <td style="border:none;padding: 0 9px 3px 0" valign="top"><?=$fetch->address;?></td>
                    </tr>
                    <tr>
                        <td style="border:none;padding: 0 9px 3px 0" valign="top">No. Telp</td>
                        <td style="border:none;padding: 0 9px 3px 0" valign="top">:</td>
                        <td style="border:none;padding: 0 9px 3px 0" valign="top"><?=$fetch->telephone;?></td>
                    </tr>
                </table>
            </td>
            <td width="50%" valign="top" style="border:none;padding:0">
                <table style="float:right">
                    <tr>
                        <td style="border:none" valign="top">Tanggal</td>
                        <td style="border:none" valign="top">:</td>
                        <td style="border:none" valign="top"><?=date("d/m/Y",strtotime($fetch->date));?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="table" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Barang</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Sub-Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach($details as $detail) {
                $i++;
            ?>

                <tr>
                    <td style="text-align:center"><?=$i;?></td>
                    <td><?=$detail->name;?></td>
                    <td style="text-align:center"><?=rupiah($detail->price);?></td>
                    <td style="text-align:center"><?=$detail->qty;?></td>
                    <td style="text-align:right"><?=rupiah($detail->qty * $detail->price);?></td>
                </tr>

            <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Total</td>
                <td style="text-align:right"><?=rupiah($fetch->total);?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>