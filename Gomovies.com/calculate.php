<?php
function calculate ($x,$y,$Nparticles,$T_MAX)
{
$m = count($y); //number of training examples
	
$W_0	= 1;
$W_T	=	0;
$MAX_V =	.9999;
$MIN_V = -.9999;
$MAX_theta= $MAX_V;
$MIN_theta= 0;
$c1	=	1;
$c2	=	1;
$Nvariables	= count($x[0]); //number of criterias = 5
$G=0;

	$P=array();
// P = struct('theta',  {},'v',  {},'theta_star',  {},'f',  0,'p_best',  0);
    for ($i=0;$i<$Nparticles;$i++)
	{
		$P[$i]=array();
		$P[$i]['theta']=array();
   		for($j=0;$j<$Nvariables;$j++)
   		$P[$i]['theta'][$j]=get_rand($MIN_theta,$MAX_theta);
		$P[$i]['v']=array();
   		for($j=0;$j<$Nvariables;$j++)
   		$P[$i]['v'][$j]=get_rand(0,$MAX_V);
        
		 $xty=array_fill(0,$m,0);
	 for($k=0;$k<$m;$k++)
	 {
		 for($j=0;$j<$Nvariables;$j++)
		$xty[$k] = $xty[$k]+ $x[$k][$j]*$P[$i]['theta'][$j];
		 $xty[$k] = $xty[$k]-$y[$k];
	 }

	 $P[$i]['f'] = computeCostMulti($xty);	 
				$P[$i]['p_best']=$P[$i]['f'];
                $P[$i]['theta_star']=$P[$i]['theta'];
			if ($P[$i]['f']< $P[$G]['f'])
            {
			$G=$i;
			}
	}
	
	/* for ($i=0;$i<$Nparticles;$i++)
	{
		echo "<br>".'printing for '.($i+1)."<br>"; 
	print_r($P[$i]['theta']);echo "<br>"; 
	print_r($P[$i]['v']);echo "<br>";
 	echo "f=".$P[$i]['f']."<br>";
	echo "p_best=".$P[$i]['p_best']."<br>";
	}*/
    
    	$w=$W_0;
	for ($t=1;$t<=$T_MAX;$t++) 
	{
		for ($i=0;$i<$Nparticles;$i++)
		{
            $r1=get_rand(0,1);
            $r2=get_rand(0,1);
			for ($j=0;$j<$Nvariables;$j++)
			{
				$P[$i]['v'][$j]=$w*$P[$i]['v'][$j]+$c1*$r1*($P[$i]['theta_star'][$j]-$P[$i]['theta'][$j])+$c2*$r2*($P[$G]['theta_star'][$j]-$P[$i]['theta'][$j]);
				if ($P[$i]['v'][$j]<$MIN_V)
					$P[$i]['v'][$j]=$MIN_V;
                elseif ($P[$i]['v'][$j]>$MAX_V)
					$P[$i]['v'][$j]=$MAX_V;
				
               //printf('xyz for particle %d at iteration %d\n',$i,$t);
                    if (($P[$i]['theta'][$j]+$P[$i]['v'][$j])>$MAX_theta)
                       {$P[$i]['v'][$j]=$MAX_theta-$P[$i]['theta'][$j]; $P[$i]['theta'][$j]=$MAX_theta;}
                    elseif (($P[$i]['theta'][$j]+$P[$i]['v'][$j])<$MIN_theta)
                        {$P[$i]['v'][$j]=$MIN_theta-$P[$i]['theta'][$j]; $P[$i]['theta'][$j]=$MIN_theta;}
                    else
                        $P[$i]['theta'][$j]=$P[$i]['theta'][$j]+$P[$i]['v'][$j];
                    
			}
		
				 $xty=array_fill(0,$m,0);
			 for($k=0;$k<$m;$k++)
			 {
				 for($j=0;$j<$Nvariables;$j++)
				$xty[$k] = $xty[$k]+ $x[$k][$j]*$P[$i]['theta'][$j];
				 $xty[$k] = $xty[$k]-$y[$k];
			 }
		
			 $P[$i]['f'] = computeCostMulti($xty);	 
			if ($P[$i]['f']< $P[$i]['p_best'])
            {
				if($P[$i]['f']< $P[$G]['p_best'])
                    $G=$i;
                
				$P[$i]['p_best']=$P[$i]['f'];
                $P[$i]['theta_star']=$P[$i]['theta'];
			}
		}		
		$w=$w-($W_0-$W_T)/$T_MAX;
	}
	
	 /*for ($i=0;$i<$Nparticles;$i++)
	{
		echo "<br>".'printing for '.($i+1)."<br>"; 
	print_r($P[$i]['theta']);echo "<br>"; 
	print_r($P[$i]['theta_star']);echo "<br>";
 	echo "f=".$P[$i]['f']."<br>";
	echo "p_best=".$P[$i]['p_best']."<br>";
	}*/
      
$res= $P[$G]['theta'];
return $res;
}

?>