<?php  
	include("connectToDatabase.php");

	// Perform queries 
	$result = mysqli_query($con,"
		SELECT userVideoGameId
        FROM userVideoGames
        WHERE userId=$_SESSION[userId]");
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			session_start();
            echo "<a href='./map.php?gameId=$row[videoGameId]'><table class='cover'>
                <tr class='cover'>
                    <td>
                        <img class='cover' src='./Assets/GameCovers/$row[coverPath]'>
                        </td>
                    </tr>
                    <tr class='title'>
                        <td>
                            $row[name]
                        </td>
                    </tr>
                <td>      
                    </td>";
            echo "</table></a>";
        }
    }

?>