<?php


class XOXO
{
	protected  $Xigrac, $Oigrac, $igrac_na_redu, $brojPoteza;	
	protected $b=array(), $pobjednik= array(); //U sa poljem pobjednik ćemo kasnije označiti pobjednička polja
	protected $errorMsg, $kraj_poruka;

	function __construct()
	{
		$this->Xigrac = false;
		$this->Oigrac = false;
		$this->igrac_na_redu=false;
		$this->errorMsg = false;
		$this->kraj_poruka=false;
		$this->brojPoteza=0; 
		for($i=1; $i<=9;$i++)
		{
			$this->b[$i]=" ";
			$this->pobjednik[$i]=" ";

		}
	}

	function ispisiFormuZaIme()
	{
		// Forma koja učitava imena igrača
		?>

		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<title>Welcome to XO!</title>
			<link rel="stylesheet" type="text/css" href="naslovna.css" />
		</head>
		<body>
			<h1>Welcome to XO!</h1>
			<div class="forma_imena">
			<form method="post" action="<?php echo htmlentities( $_SERVER['PHP_SELF']); ?>">
				player X <input type="text" name="Xigrac" /><br>
				player O <input type="text" name="Oigrac" /><br>
				<button type="submit" class="start">START</button>
			</form>
			

			<?php if( $this->errorMsg !== false ) echo '<p>Greška: ' . htmlentities( $this->errorMsg ) . '</p>'; ?>
			</div>
		</body>
		</html>

		<?php
	}

	function get_imeIgracaX()
	{
		//ako već imamo ime igrača
		if( $this->Xigrac !== false )
			return $this->Xigrac;

		//ako upravo dohvaćamo ime
		if( isset( $_POST['Xigrac'] ) )
		{
			// Šalje nam se ime igrača. Provjeri da li se sastoji samo od slova.
			if( !preg_match( '/^[a-zA-Z]{1,20}$/', $_POST['Xigrac'] ) )
			{
				// Nije dobro ime. Dakle nemamo ime igrača.
				$this->errorMsg = 'Ime igrača X treba imati između 1 i 20 slova.';
				return false;
			}
			else
			{
				// Dobro je ime. Spremi ga u objekt.
				$this->Xigrac = $_POST['Xigrac'];
				return $this->Xigrac;
			}
		}

		// Ne šalje nam se sad ime. Dakle nemamo ga uopće.
		return false;
	}

	function get_imeIgracaO()
	{
		// Je li već definirano ime igrača?
		if( $this->Oigrac !== false )
			return $this->Oigrac;

		// Možda nam se upravo sad šalje ime igrača?
		if( isset( $_POST['Oigrac'] ) )
		{
			// Šalje nam se ime igrača. Provjeri da li se sastoji samo od slova.
			if( !preg_match( '/^[a-zA-Z]{1,20}$/', $_POST['Oigrac'] ) )
			{
				// Nije dobro ime. Dakle nemamo ime igrača.
				$this->errorMsg = 'Ime igrača O treba imati između 1 i 20 slova.';
				return false;
			}
			else
			{
				// Dobro je ime. Spremi ga u objekt.
				$this->Oigrac = $_POST['Oigrac'];
				return $this->Oigrac;
			}
		}

		// Ne šalje nam se sad ime. Dakle nemamo ga uopće.
		return false;
	}

	//ispisuje formu križić kružića
	//ispisuje i greške ako ih ima, te tko je idući na redu
	//na kraju ispisujemo reset button(on služi kako ne bi igrači morali stalno ponovo upisivati svoja imena, 
	// već samo da očiste ploču. na kraju igre pritiskom na bilo koji gumb osim resetiraj, vraćamo se na formu za upis imena)
	function ispisiFormuIgre()
	{
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<title>Welcome to XO</title>
			<link rel="stylesheet" type="text/css" href="naslovna.css" />
		</head>
		<body>
			<h1>Welcome to XO!</h1>	

			<div class=igra>
			<form class="forma_igre" method="post" action="<?php echo htmlentities( $_SERVER['PHP_SELF']); ?>">
				<br />
				<table class="board">
				<tr> 
				<td><button class="button" type="submit" name="b1" <?php echo 'id="'. $this->pobjednik[1]. '"'?>> <?php echo $this->b[1];?></button></td>
				<td><button class="button" type="submit" name="b2" <?php echo 'id="'. $this->pobjednik[2]. '"'?>> <?php echo $this->b[2];?></button></td>
				<td><button class="button" type="submit" name="b3" <?php echo 'id="'. $this->pobjednik[3]. '"'?>> <?php echo $this->b[3];?></button></td>
				</tr>
				<tr>
				<td><button class="button" type="submit" name="b4" <?php echo 'id="'. $this->pobjednik[4]. '"'?>> <?php echo $this->b[4];?></button></td>
				<td><button class="button" type="submit" name="b5" <?php echo 'id="'. $this->pobjednik[5]. '"'?>> <?php echo $this->b[5];?></button></td>
				<td><button class="button" type="submit" name="b6" <?php echo 'id="'. $this->pobjednik[6]. '"'?>> <?php echo $this->b[6];?></button></td>
				</tr>
				<tr>
				<td><button class="button" type="submit" name="b7" <?php echo 'id="'. $this->pobjednik[7]. '"'?>> <?php echo $this->b[7];?></button></td>
				<td><button class="button" type="submit" name="b8" <?php echo 'id="'. $this->pobjednik[8]. '"'?>> <?php echo $this->b[8];?></button></td>
				<td><button class="button" type="submit" name="b9" <?php echo 'id="'. $this->pobjednik[9]. '"'?>> <?php echo $this->b[9];?></button></td>
				</tr>
				</table>
			</form>

			<?php if( $this->errorMsg !== false ) echo '<p>Greška: ' . htmlentities( $this->errorMsg ) . '</p>'; ?>

			<p> <?php
				if($this->kraj_poruka===false)
				{ ?>
				    Play  
					<?php 
					// ispisujemo ime igrača koji je na redu
					if ($this->igrac_na_redu=== 'x') echo htmlentities( $this->Xigrac . ' (igrac ' . $this->igrac_na_redu . ' )' ); 
						  else echo htmlentities($this->Oigrac. ' (igrac ' . $this->igrac_na_redu . ' )' );
				} 
				else
				{
					//osim ako je kraj igre. onda ispisujemo da nema pobjednika ako je izjednačeno ili tko je pobjednik
					if ($this->kraj_poruka==='draw') echo htmlentities('No winner!');
					else if ($this->kraj_poruka==='x') echo htmlentities('And the winner is '. $this->Xigrac . ' (igrac x)!');
					else if($this->kraj_poruka==='o') echo htmlentities('And the winner is '. $this->Oigrac. ' (igrac o)!');
				} ?>
			</p>
			<form method="post" action="<?php echo htmlentities( $_SERVER['PHP_SELF']); ?>">
				<button type="submit" name ="reset" class="restart">Restart game</button>
			</form>
			</div>

		</body>
		</html>

		<?php
	}

	function obradiGumb($brojGumba) //obrađuje gumbe od 1 do 9, odnosno polja igre
	{

		$gumb= 'b'. (string) $brojGumba;
		if( isset( $_POST[$gumb] ) )  
		{

			//ako je polje već postavljeno
			if ($this->b[$brojGumba]==='x' || $this->b[$brojGumba]==='o')
				{$this->errorMsg = 'Stisnuli ste na već označeno polje';return false;}
			
			//ako polje još nije postavljeno
			else 
			{
				if ($this->igrac_na_redu==='x') $this->b[$brojGumba]='x'; 
				else if($this->igrac_na_redu==='o')$this->b[$brojGumba]='o';
				++$this->brojPoteza;
				return true;
			}
		}

	}
	

	function obradiPokusaj() //prolazi sve gumbe i gleda ima li koji gumb koji je stisnut
	{
		for($i=1;$i<=9;$i++)
		{
			if ($this->obradiGumb($i)===true) return true;
		}
		if( isset( $_POST['reset'] ) ) //ako je stisnut gumb reset vraćamo sve vrijednosti osim imena na nulu
		{
			$this->igrac_na_redu=false;
			$this->errorMsg = false;
			$this->kraj_poruka=false;
			$this->brojPoteza=0; 
			for($i=1; $i<=9;$i++) 
			{ $this->b[$i]=" ";$this->pobjednik[$i]=" ";}
		}
		return false;
	}

	function resetiraj() 
	{
		if( isset( $_POST['reset'] ) )
		{
			$this->igrac_na_redu=false;
			$this->errorMsg = false;
			$this->kraj_poruka=false;
			$this->brojPoteza=0; 
			for($i=1; $i<=9;$i++) 
				{ $this->b[$i]=" ";$this->pobjednik[$i]=" ";}
			return true;
		}
	}

	function provjeri_redak($red) // funkcija provjerava je li u jednom redu pobjeda
	{
		if ($this->b[$red]===$this->b[$red+1] && $this->b[$red+1]===$this->b[$red+2] ) //ovaj pogleda prvo dal su sve varijable u istom redu iste
		{
			if($this->b[$red]==='x' || $this->b[$red]==='o') //onda gledamo jesu li jednake x ili jednake o znači da imamo pobjedu
			{
				//idući redak postavlja polja na pobjednička da ih možemo posebno pobojati
				$this->pobjednik[$red]= $this->pobjednik[$red+1]= $this->pobjednik[$red+2] ='win';
				if($this->b[$red]==='x') $this->kraj_poruka='x';
				else $this->kraj_poruka='o';
				return true;
			}
		}
		return false;
		
	}

	function provjeri_stupac($stupac) //analogno funkciji provjeri_redak samo za stupce
	{
		if ($this->b[$stupac]===$this->b[$stupac+3] && $this->b[$stupac+3]===$this->b[$stupac+6] ) //ovaj pogleda prvo dal su sve varijable u istom redu iste
		{
			if($this->b[$stupac]==='x' || $this->b[$stupac]==='o') //onda gledamo jesu li jednake x ili jednake o znači da imamo pobjedu
			{
				//idući redak postavlja polja na pobjednička da ih možemo posebno pobojati
				$this->pobjednik[$stupac]= $this->pobjednik[$stupac+3]= $this->pobjednik[$stupac+6] ='win';
				if($this->b[$stupac]==='x') $this->kraj_poruka='x';
				else $this->kraj_poruka='o';
				return true;
			}
		}
		return false;
		
	}

	function pobjeda() //provjerava slučajeve pobjeda
	{
		for($i=1; $i<8; $i+=3) // provjere retka 
		{
			if ($this->provjeri_redak($i)) return true;
		}

		for($j=1; $j<4; ++$j) // provjere stupca
		{
			if ($this->provjeri_stupac($j)) return true;
		}

		//provjere dijagonala

		if ($this->b[1]===$this->b[5]&& $this->b[5]===$this->b[9] && $this->b[9]==='x' ) {$this->kraj_poruka='x';$this->pobjednik[1]='win';$this->pobjednik[5]='win';$this->pobjednik[9]='win';return true;}
		if ($this->b[3]===$this->b[5]&& $this->b[5]===$this->b[7] && $this->b[7]==='x' ) {$this->kraj_poruka='x';$this->pobjednik[3]='win';$this->pobjednik[5]='win';$this->pobjednik[7]='win';return true;}

		if ($this->b[1]===$this->b[5]&& $this->b[5]===$this->b[9] && $this->b[9]==='o' ) {$this->kraj_poruka='o';$this->pobjednik[1]='win';$this->pobjednik[5]='win';$this->pobjednik[9]='win';return true;}
		if ($this->b[3]===$this->b[5]&& $this->b[5]===$this->b[7] && $this->b[7]==='o' ) {$this->kraj_poruka='o';$this->pobjednik[3]='win';$this->pobjednik[5]='win';$this->pobjednik[7]='win';return true;}


		return false;


	}

	function isGameOver() 
	{ 
		if ($this->brojPoteza===9) 
		{	
			$this->kraj_poruka='draw';
			return 1;
		}
		return 0;
	}

	function kreni()
	{
		// Funkcija obavlja "jedan potez" u igri.
		// Prvo, resetiraj poruke o greški.
		$this->errorMsg = false;
		$this->resetiraj(); 
		//ako smo poslali resetiraj prvo resetiramo sve (možda je reset nakon što je netko pobijedio pa ih ne želimo izlogirati nego samo postavimo sve na početno osim imena)
		//u suprotnom ako je kraj igre pritiskom na bilo koji drugi gumb vraćamo se na formu za unošenje imena
		if( $this->kraj_poruka !== false )
		{
			return false;
		}
		
		// provjeravamo imamo li imena igrača
		if( $this->get_imeIgracaO() === false || $this->get_imeIgracaX() === false )
		{
			// ako ne, ispisujemo formu za unos imena
			$this->ispisiFormuZaIme();
			return;
		}
		

		if( $this->obradiPokusaj() === false ) //obradi pokusaj gleda zadnji potez koji smo napravili. i brine se ako netko stisne krivi gumb da opet ispisujemo formu igre
		{
			if($this->igrac_na_redu === false)  $this->igrac_na_redu='x'; //prvije prvog poteza, postavljanje prvog igrača na x
			$this->ispisiFormuIgre(); 
			return;
		}
		
		// nakon poteza (obradi pokušaj) zamjenjujemo igraca koji je na redu
		if($this->igrac_na_redu === 'x') $this->igrac_na_redu='o';
		else if($this->igrac_na_redu==='o' ) $this->igrac_na_redu='x';

		//ako smo pobijedili ispisujemo formu s porukom pobjede, inače ispisujemo formu s porukom izjednačenosti, ili ispisujemo normalnu formu dalje
		if($this->pobjeda()) $this->ispisiFormuIgre();
		else if($this->isGameOver()) $this->ispisiFormuIgre(); 
		else $this->ispisiFormuIgre();			
		
	}

};
// GLAVNI PROGRAM

session_start();

if( !isset( $_SESSION['play'] ) )
{
	// Ako igra još nije započela, stvori novi objekt tipa XOXO i spremi ga u $_SESSION
	$play = new XOXO();
	$_SESSION['play'] = $play;
}
else
{
	// Ako je igra već ranije započela, dohvati ju iz $_SESSION-a	
	$play = $_SESSION['play'];
}


if($play->kreni()===false)
{
	session_unset();
	session_destroy();
	header("Location: xo.php");
}
else
{
	// Igra još nije gotova -> spremi trenutno stanje u SESSION
	$_SESSION['play'] = $play;
}
