<?php
$namajilid  = mysqli_query($con, "select concat(tblall.nmjilid,' ', nmbagian) as nmjilidall, tblall.* from 
(
select tbl1.* from
(select tj.id, tbl1.nmjilid, tj.nmjilid as nmbagian, count(sh.c_siswa) as jml, tj.seqjilid from tbl_jilid tj
left join sisjilid_h sh on tj.id = sh.idjilid 
left join (select distinct tj2.id, tj2.nmjilid from tbl_jilid tj2 ) as tbl1 
on tj.parentid  = tbl1.id
where tj.parentid != 0
and coalesce(sh.flag, 'N') = 'N'
group by tj.id, tj.nmjilid, tbl1.nmjilid, tj.seqjilid
order by tj.seqjilid) as tbl1
union 
select tbl2.* from
(
select tj.id, '' nmjilid, tj.nmjilid as nmbagian, count(sh.c_siswa) as jml, tj.seqjilid  from tbl_jilid tj
left join sisjilid_h sh on tj.id = sh.idjilid  
where tj.parentid = 0 and tj.seqjilid  > 14
and coalesce(sh.flag, 'N') = 'N'
group by tj.id, tj.nmjilid, tj.seqjilid
order by tj.seqjilid) as tbl2) as tblall
order by seqjilid");

$jmlsisjilid  = mysqli_query($con, "select concat(tblall.nmjilid, nmbagian) as nmjilidall, tblall.* from 
(
select tbl1.* from
(select tj.id, tbl1.nmjilid, tj.nmjilid as nmbagian, count(sh.c_siswa) as jml, tj.seqjilid from tbl_jilid tj
left join sisjilid_h sh on tj.id = sh.idjilid 
left join (select distinct tj2.id, tj2.nmjilid from tbl_jilid tj2 ) as tbl1 
on tj.parentid  = tbl1.id
where tj.parentid != 0
and coalesce(sh.flag, 'N') = 'N'
group by tj.id, tj.nmjilid, tbl1.nmjilid, tj.seqjilid
order by tj.seqjilid) as tbl1
union 
select tbl2.* from
(
select tj.id, '' nmjilid, tj.nmjilid as nmbagian, count(sh.c_siswa) as jml, tj.seqjilid  from tbl_jilid tj
left join sisjilid_h sh on tj.id = sh.idjilid  
where tj.parentid = 0 and tj.seqjilid  > 14
and coalesce(sh.flag, 'N') = 'N'
group by tj.id, tj.nmjilid, tj.seqjilid
order by tj.seqjilid) as tbl2) as tblall
order by seqjilid");

?>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"> <i class="glyphicon glyphicon-stats"></i> Performansi Kelas</h3>
    </div>

    <canvas id="myChart" width="200" height="100"></canvas>

    <div class="row">
    <div class="col-sm-6">
    <div class="box-body table-responsive">
    <p><h3>MURID PERFORMANCE</h3></p>
            <table id="example1" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th width="5%">No</th>
                <th>NAMA-NISN</th>
                <th>Kelas</th>
                <th>Tgl. Naik</th>
                <th>Jumlah Hari</th>
            </tr>
            </thead>
            <tbody>
            <?php $smk2=mysqli_query($con,"select sj.idjilid, sj.nmjilid, sj.c_siswa, s.nama, 
                            s.nisn, sj.tglnaikjilid, DATEDIFF(CURRENT_DATE(), sj.tglnaikjilid) jmlhari  from sisjilid_h sj
                            inner join siswa s on sj.c_siswa = s.c_siswa where DATEDIFF(CURRENT_DATE(), sj.tglnaikjilid) <= 30 ");
            $vr=1;
            while($akh=mysqli_fetch_array($smk2)){?>
                <tr>
                  <td><?php echo $vr; ?></td>
                  <td>
                    <?php echo $akh['nama'] . ' - ' ; echo $akh['nisn']; ?>
                </td>
                  <td>
                  <?php echo $akh['nmjilid']; ?>
                </td>
                  <td><?php echo date('Y-m-d',strtotime($akh['tglnaikjilid'])) ; ?></td>
                  <td><?php echo $akh['jmlhari']; ?></td>
                </tr>
            <?php $vr++;
            }?>
            </tbody>

        </table>
    </div>
    </div>
    <div class="col-sm-6">
    <div class="box-body table-responsive">
    <p><h3>MURID YANG PERLU MENDAPAT PERHATIAN</h3></p>
            <table id="example1" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th width="5%">No</th>
                <th>NAMA-NISN</th>
                <th>Kelas</th>
                <th>Tgl. Naik</th>
                <th>Lama Tidak Naik(Hari)</th>
            </tr>
            </thead>
            <tbody>
            <?php $smk2=mysqli_query($con,"select sj.idjilid, sj.nmjilid, sj.c_siswa, s.nama, 
                            s.nisn, sj.tglnaikjilid, DATEDIFF(CURRENT_DATE(), sj.tglnaikjilid) jmlhari  from sisjilid_h sj
                            inner join siswa s on sj.c_siswa = s.c_siswa where DATEDIFF(CURRENT_DATE(), sj.tglnaikjilid) >= 40 ");
            $vr=1;
            while($akh=mysqli_fetch_array($smk2)){?>
                <tr>
                  <td><?php echo $vr; ?></td>
                  <td>
                    <?php echo $akh['nama'] . ' - ' ; echo $akh['nisn']; ?>
                </td>
                  <td>
                  <?php echo $akh['nmjilid']; ?>
                </td>
                  <td><?php echo date('Y-m-d',strtotime($akh['tglnaikjilid'])) ; ?></td>
                  <td><?php echo $akh['jmlhari']; ?></td>
                </tr>
            <?php $vr++;
            }?>
            </tbody>

        </table>
    </div>
    </div>
</div>
    

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.bundle.min.js" crossorigin="anonymous"></script>
<script>
            var ctx = document.getElementById("myChart").getContext("2d");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [<?php while ($b = mysqli_fetch_array($namajilid)) { echo '"' . $b['nmjilidall'] . '",';}?>],
                    datasets: [{
                            label: '# Jumlah Murid Per Juz',
                            data: [<?php while ($p = mysqli_fetch_array($jmlsisjilid)) { echo '"' . $p['jml'] . '",';}?>],
                            backgroundColor: '#20A3FD',
                            borderColor: '#46d5f1',
                            borderWidth: 1
                        }]
                },
                options: {
                    scales: {
                        yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                    },
                    responsive: true,
                    plugins: {
                        datalabels: { // This code is used to display data values
                            anchor: 'end',
                            align: 'top',
                            font: {
                                weight: 'bold',
                                size: 16
                            }
                        }
                    }
                }
            });

        </script>