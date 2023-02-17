<html>
    <head>
    <head>
    <title>Data Buku</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- css bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>
    <body>
    <div class="container">
        <div align="center">
        <h2>Data Buku 0320210079</hr>
     </div>
    <form method="GET">
        <div class="row">
        <div class="col-md-5">
        <div class="panel panel-default">
        <div style="background-color: green;" class="panel-heading"><b>Pencarian</b></div>
        <div class="panel-body">
        <form class="form-inline" >
            <input type="text" class="form-control" id="KataCari" name="KataCari" placeholder="Cari. . ." value="<?php if (isset($_GET['KataCari']))  echo $_GET['KataCari']; ?>">
        </div>
        <button type="submit" name="cari" class="btn btn-primary">Cari</button>
       
        <a href="data_buku.php" class="btn btn-danger">Reset</a>
        </form>
        </div>
      </div>
    </div>
  </div>
  <!-- SpreadSheet -->
  <form action="report.php" method="post" name="spreadsheet" id="spreadsheet">  
              <input type="submit" id="spreadsheet" name="spreadsheet"class="btn btn-primary" value="Spreadsheet"/>
              <?php $kolomCari=(isset($_GET['KataCari']))? $_GET['KataCari'] : ""; ?>   
              <input type="hidden" id="spreadsheet" name="spreadsheet" value="<?php echo $kolomCari;?>"/> 
  </form><br>
    <table style="width:95%; margin-left: 50px;" class="table table-striped table-bordered table-hover">
        <thead>
            <tr style="background-color: greenyellow;">
            <th>No</th>
            <th>ID</th>
            <th>Nama</th>
            <th>Jenis</th>
            <th>buku</th>
            </tr>
        </thead>
        <tbody>  
        
                            <?php
                            $cari = "";

                            if (isset($_GET['submitSearch'])) {
                                $cari = $_GET['txtCari'];
                                echo "<b>Hasil pencarian dari \" " . $cari . "\"</b>";
                            }
                            ?>
        <?php
            require('koneksi.php');
            $page = (isset($_GET['page']))? (int) $_GET['page'] : 1;
            $kolomKataKunci=(isset($_GET['KataKunci']))? $_GET['KataKunci'] : ""; 
            $limit = 5;
            $limitStart = ($page - 1) * $limit;
            if(isset($_GET['cari']))
            {
                if($kolomKataKunci==""){
                $view = mysqli_query($con, "SELECT * FROM buku LIMIT ".$limitStart.",".$limit);
                }else{
                //kondisi jika parameter kolom pencarian diisi
                $view = mysqli_query($con, "SELECT * FROM buku WHERE id_buku LIKE '%$kolomKataKunci%' OR nama_buku LIKE '%$kolomKataKunci%'
                OR id_jenis_buku LIKE '%$kolomKataKunci%' OR id_vendor LIKE '%$kolomKataKunci%'  LIMIT ".$limitStart.",".$limit);
                }
            }
            else{
                $view = mysqli_query($con, "SELECT * FROM buku LIMIT ".$limitStart.",".$limit);
                }
                $no = $limitStart + 1;
                $baris=1;
                while($row = mysqli_fetch_array($view)){
        ?>
                <tr>
                <td><?php echo $baris ?></td>
                <td><?php echo $row['id_buku'] ?></td>
                <td><?php echo $row['nama_buku'] ?></td>
                <td><?php echo $row['id_jenis_buku'] ?></td>
                <td><?php echo $row['id_vendor'] ?></td>
                <td><?php echo $row['jml_stok'] ?></td>
                </tr>
        <?php
                $baris++;
            }
            ?>
            </tbody>
        </table>
        <div align="right">
                <ul class="pagination">
                    <?php
                        // Jika page = 1, maka LinkPrev disable
                        if($page == 1){ 
                    ?>        
                        <!-- link Previous Page disable --> 
                        <li class="disabled"><a href="#">Previous</a></li>
                    <?php
                        }
                        else{ 
                            $LinkPrev = ($page > 1)? $page - 1 : 1;  

                            if($kolomKataKunci==""){
                    ?>
                            <li><a href="data_buku.php?page=<?php echo $LinkPrev; ?>">Previous</a></li> 
                    <?php
                            }else{
                    ?>
                            <li><a href="data_buku.php?KataKunci=<?php echo $kolomKataKunci;?>&page=<?php echo $LinkPrev;?>">Previous</a></li>
                    <?php
                                } 
                            }
                   ?>
                    <?php
                        //kondisi jika parameter pencarian kosong
                        if($kolomKataKunci==""){
                            $view = mysqli_query($con, "SELECT * FROM buku");
                        }else{
                        //kondisi jika parameter kolom pencarian diisi
                        $view = mysqli_query($con, "SELECT * FROM buku WHERE id_buku LIKE '%$kolomKataKunci%' OR nama_buku LIKE '%$kolomKataKunci%'
                        OR id_jenis_buku LIKE '%$kolomKataKunci%' OR id_vendor LIKE '%$kolomKataKunci%'  LIMIT ".$limitStart.",".$limit);
                        }
                    
                        //Hitung semua jumlah data yang berada pada tabel Sisawa
                        $JumlahData = mysqli_num_rows($view);
                        
                        // Hitung jumlah halaman yang tersedia
                        $jumlahPage = ceil($JumlahData / $limit); 
                        
                        // Jumlah link number 
                        $jumlahNumber = 1; 

                        // Untuk awal link number
                        $startNumber = ($page > $jumlahNumber)? $page - $jumlahNumber : 1; 
                        
                        // Untuk akhir link number
                        $endNumber = ($page < ($jumlahPage - $jumlahNumber))? $page + $jumlahNumber : $jumlahPage; 
                        
                        for($i = $startNumber; $i <= $endNumber; $i++){
                            $linkActive = ($page == $i)? ' class="active"' : '';

                            if($kolomKataKunci==""){
                    ?>
                            <li<?php echo $linkActive; ?>><a href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>

                    <?php
                        }else{
                    ?>
                            <li<?php echo $linkActive; ?>><a href="index.php?KataKunci=<?php echo $kolomKataKunci;?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php
                        }
                        }
                    ?>
                        <!-- link Next Page -->
                    <?php       
                        if($page == $jumlahPage){ 
                    ?>
                        <li class="disabled"><a href="#">Next</a></li>
                    <?php
                        }
                        else{
                        $linkNext = ($page < $jumlahPage)? $page + 1 : $jumlahPage;
                        if($kolomKataKunci==""){
                            ?>
                            <li><a href="index.php?page=<?php echo $linkNext; ?>">Next</a></li>
                        <?php     
                            }else{
                    ?> 
                            <li><a href="index.php?KataKunci=<?php echo $kolomKataKunci;?>&page=<?php echo $linkNext; ?>">Next</a></li>
                    <?php
                        }
                        }
            //             require('report.php');
            //             if(isset($_GET['export']))
            // {
            //             $ss= new SpreadSheet();
            //             $ss->export($view);
            // }
                    ?>
                  </ul>
                </div>
            </div>
        </form>
    </body>
</html>


