<?php
include "config.php";
$search_term = $_POST["search"];
   /* Calculate Offset Code 
   $limit = 3;
   if(isset($_GET['page']))
   {
     $page = $_GET['page'];
   }
   else{
     $page = 1;
   }
   $offset = ($page - 1) * $limit;
*/

   $sql = "SELECT post.post_id, post.title, post.description,post.post_date,post.author,
   category.category_name,user.username,post.category,post.post_img FROM post
   LEFT JOIN category ON post.category = category.category_id
   LEFT JOIN user ON post.author = user.user_id
   WHERE post.title LIKE '%{$search_term}%' OR post.description LIKE '%{$search_term}%'
   ORDER BY post.post_id DESC";
    $result = mysqli_query($conn, $sql) or die("SQL Query Failed.");
    $output = "";
if(mysqli_num_rows($result) > 0 )
{
  //$output.= "<h2 class='page-heading'>Search :'.$search_term.'</h2>";

              while($row = mysqli_fetch_assoc($result)){
                $output.=" <div class='post-content'>
                <div class='row'>
                    <div class='col-md-4'>
                    <a class='post-img' href='single.php?id=<?php echo {$row['post_id']}; ?>'>
                    <img src='admin/upload/<?php echo {$row['post_img']}; ?>' alt=''/></a>
                    </div>
                    <div class='col-md-8'>
                      <div class='inner-content clearfix'>
                          <h3><a href='single.php?id=<?php echo {$row['post_id']}; ?>'><?php echo {$row['title']}; ?></a></h3>
                          <div class='post-information'>
                              <span>
                                  <i class='fa fa-tags' aria-hidden='true'></i>
                                  <a href='category.php?cid=<?php echo {$row['category']}; ?>'><?php echo {$row['category_name']}; ?></a>
                              </span>
                              <span>
                                  <i class='fa fa-user' aria-hidden='true'></i>
                                  <a href='author.php?aid=<?php echo {$row['author']}; ?>'><?php echo {$row['username']}; ?></a>
                              </span>
                              <span>
                                  <i class='fa fa-calendar' aria-hidden='true'></i>
                                  <?php echo {$row['post_date']}; ?>
                              </span>
                          </div>
                          <p class='description'>
                              <?php echo substr({$row['description']},0,130) .'...'; ?>
                          </p>
                          <a class='read-more pull-right' href='single.php?id=<?php echo {$row['post_id']}; ?>'>read more</a>
                      </div>
                    </div>
                </div>
            </div>";
              }

               // show pagination
  /*  $sql1 = "SELECT * FROM post WHERE post.title LIKE '%{$search_term}%'";
    $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");

    if(mysqli_num_rows($result1) > 0)
    {

        $total_records = mysqli_num_rows($result1);

        $total_page = ceil($total_records / $limit);

        $output.="<ul class='pagination admin-pagination'>";
        if($page > 1){
        $output .= "<li><a href='ajax-live-search.php?search='.$search_term .'&page='.($page - 1).''>Prev</a></li>";
        }
        for($i = 1; $i <= $total_page; $i++){
            if($i == $page)
            {
            $active = "active";
            }else{
            $active = "";
            }
            $output .="<li class=$active><a href='ajax-live-search.php?search='.$search_term .'&page='.$i.''>'.$i.'</a></li>";
        }
        if($total_page > $page)
        {
        $output .= "<li><a href='ajax-live-search.php?search='.$search_term .'&page='.($page + 1).''>Next</a></li>";
        }
        $output .="</ul>";
    }

/*}else{$output.="<h2>No Record Found.</h2>";
}*/

$output .="</div>
</div>";
$output.=" </div>
</div>
</div>";
$output.= "</div>
<?php include 'sidebar.php'; ?>";

    mysqli_close($conn);

    echo $output;
}else{
    echo "<h2>No Record Found.</h2>";
}
?>