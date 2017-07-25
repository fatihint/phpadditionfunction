<form method="POST">
<input type="text" name="numbers" placeholder="toplamak istediginiz sayilari aralarina + isareti koyarak yaziniz." style="width: 400px">
</br>
</br>
<input type="submit" name="islem" value="Bu islemin cevabi">
</form> </br></br>

<?php
function Addition($operation){


      // 10x10 luk matris.
      // Addition fonksiyonunda, sayilar en sagdan baslayarak rakamlarina ayrilir
      // ve bu rakamlarin toplaminin degeri bu matristen bulunur.
      // ornegin 3. satir 3. sutun 6yi verir.
      // ornegin 9. satir 9. sutun 8i verir.
      $rules = array(
        0 => array(0,1,2,3,4,5,6,7,8,9),
        1 => array(1,2,3,4,5,6,7,8,9,0),
        2 => array(2,3,4,5,6,7,8,9,0,1),
        3 => array(3,4,5,6,7,8,9,0,1,2),
        4 => array(4,5,6,7,8,9,0,1,2,3),
        5 => array(5,6,7,8,9,0,1,2,3,4),
        6 => array(6,7,8,9,0,1,2,3,4,5),
        7 => array(7,8,9,0,1,2,3,4,5,6),
        8 => array(8,9,0,1,2,3,4,5,6,7),
        9 => array(9,0,1,2,3,4,5,6,7,8)
      );

        // sayilari arraye al ve toplami 0 a esitle.
        $takeNumbers = explode('+',$operation);
        $sum = 0;

        for($t=0; $t<count($takeNumbers); $t++){
            if(!is_numeric($takeNumbers[$t])){
              echo "Lutfen toplamak istediginiz sayilari aralarina + isareti koyarak yaziniz. orn: 4+70+100";
            } else{

            // !! dongunun icinde her seferinde iki sayinin toplama islemi gerceklestirilir.
            // !! ornegin 10+100+50 girildiginde, 10+0 dan gelen sonuc 100 ile, o islemden gelen sonuc ise 50 ile toplanir.
            // !! bu sayede elde degiskeninde sadece "1" elde tutulur.
            $num1 = $takeNumbers[$t];
            $num2 = $sum;

            // sayilardaki rakamlari arraye al
            $num1 = str_split($num1);
            $num2 = str_split($num2);

        if(count($num1) != count($num2)){
          // basamak sayilari esit degilse: ornegin 3 + 1000 islemi icin,
          // 3 sayisini 0003 haline getir.
          if(count($num1) < count($num2)){
            $s = count($num1);
            $b = count($num2);
            $j = $b - $s;
            for($i=0; $i<$s; $i++){
              $new[$i] = $num1[$i];
            }
            for($i=0; $i<$s; $i++){
              while($j<$b){
                $num1[$j] = $new[$i];
                // $j++;
                $j = $rules[$j][1];
                break;
              }
            }
            for($k=0; $k<($b-$s); $k++){
                $num1[$k] = 0;
            }
          } else{
            $s = count($num2);
            $b = count($num1);
            $j = $b - $s;
            for($i=0; $i<$s; $i++){
              $new[$i] = $num2[$i];
            }
            for($i=0; $i<$s; $i++){
              while($j<$b){
                $num2[$j] = $new[$i];
                // $j++;
                $j = $rules[$j][1];
                break;
              }
            }
            for($k=0; $k<($b-$s); $k++){
                $num2[$k] = 0;
            }
          }
        }

        // basamak esitsizligi giderildikten sonra
        // her iki sayinin son basamaklardan(en sagdakilerden) baslayarak, en soldaki basamaklarina dongu baslatilir.
        $elde = 0;
        $answer = array();
        for($i=(count($num1)-1); $i>=0; $i--){
          if($elde > 0){
            // islem en soldaki basamakta degilse.
              if($i != 0){
                // array_keys(icinde key aranilan array, keyi aranilan deger)[sonuc array olarak dondugu icin ve ilk degeri almak icin 0 yazilir.]
                // ornegin 9 ve 3 rakamini alalim.
                // rules arrayindeki 9. satir'in (ki bu da bir array) icerisindeki 3. degerin KEY'i
                // rules arrayindeki 9. satir'in  degeri 9 olan elementinin KEY'inden buyuk ise,
                // rakamlarin toplami 10 veya 10dan buyuk anlamina gelir, elde alinir.
                if(array_keys($rules[$num1[$i]], $rules[$num1[$i]][$num2[$i]])[0] > array_keys($rules[$num1[$i]],9)[0]){
                  // n degiskenine ise 9uncu satir 3. sutun degeri yani "2" alinir.
                  $n = $rules[$num1[$i]][$num2[$i]];
                  // onceki elde eklendi ve sonucun tutuldugu answer arrayine atildi.
                  $answer[] = $rules[$n][$elde];
                  // elde eklendigi icin tekrar 0'a esitlendi.
                  $elde = 0;
                  // 110. satirdan gelen yeni elde tekrar alindi.
                  // $elde++;
                  $elde = $rules[$elde][1];
                } else{
                  // 110. satirdaki kosul saglanmadigi icin sonuc n degiskenine alinir
                  $n = $rules[$num1[$i]][$num2[$i]];
                  // buradaki kosul ise 106. satirda kontrol ettigimiz elde degiskeni ile 125. satirdaki yeni degiskenimizin toplami "eldeli islem mi ?"
                  // ornegin 125. satirda, 4. satir 5. sutundaki sayiyi aldik, ki bu n degiskeninde 9'u tutuyoruz demektir
                  // 106. satirda kontrol ettigimiz ve bir onceki basamaklarin isleminden gelen eldemiz ile n degiskeninde tuttugumuz 9
                  // rakami 9uncu satir 1. sutun'u isaret etmektedir, ki bu da yine toplamin 10u gectigi anlamina gelir.
                    if(array_keys($rules[$n], $rules[$n][$elde])[0] > array_keys($rules[$n],9)[0]) {
                        $answer[] = $rules[$n][$elde];
                        $elde = 0;
                        // $elde++;
                        $elde = $rules[$elde][1];
                    } else {
                      // n degiskeni ve eldenin toplami 9dan buyuk degil
                      $answer[] = $rules[$n][$elde];
                      $elde = 0;
                    }
                }
              } else {
                // sonuncu (en soldaki) basamak islemi
                  if(array_keys($rules[$num1[$i]], $rules[$num1[$i]][$num2[$i]])[0] > array_keys($rules[$num1[$i]],9)[0]){
                    $n = $rules[$num1[$i]][$num2[$i]];
                    $answer[] = "1".$rules[$n][$elde];
                    // onceki elde islemleri yapildi, tek fark islem en soldaki basamakta oldugu icin,
                    // eldemiz arttirilmak yerine sonucun yanina yazildi. (bkz. 56. satir)
                    $elde = 0;
                  } else {
                    $n = $rules[$num1[$i]][$num2[$i]];
                      if(array_keys($rules[$n], $rules[$n][$elde])[0] > array_keys($rules[$n],9)[0]){
                        $answer[] = "1".$rules[$n][$elde];
                        $elde = 0;
                      } else {
                        $answer[] = $rules[$n][$elde];
                        $elde = 0;
                      }
                  }
              }
          }
          else{
            // bir onceki islemden `elde` gelmeyen islemlerin basladigi yer.
            // dongu bittiginde yeni sonuc answer arrayinde tutulmus oldu.
            if($i != 0){
              if(array_keys($rules[$num1[$i]], $rules[$num1[$i]][$num2[$i]])[0] > array_keys($rules[$num1[$i]],9)[0]){
                $answer[] = $rules[$num1[$i]][$num2[$i]];
                // $elde++;
                $elde = $rules[$elde][1];
              } else {
                $answer[] = $rules[$num1[$i]][$num2[$i]];
                $elde = 0;
              }
            } else {
                if(array_keys($rules[$num1[$i]], $rules[$num1[$i]][$num2[$i]])[0] > array_keys($rules[$num1[$i]],9)[0]){
                    $answer[] = "1".$rules[$num1[$i]][$num2[$i]];
              } else {
                    $answer[] = $rules[$num1[$i]][$num2[$i]];
              }
            }
          }
        }
        // sayilar en sag basamaktan toplanmaya basladigi icin, ters sekilde newSum degiskenine attik.
        for($j=(count($answer)-1); $j>=0; $j--){
          $newSum[] = $answer[$j];
        }
        // newSum degiskenini bir sonraki islem icin temizle,
        //45. satira don
        $sum = implode($newSum);
        unset($newSum);
    }
  }
        // cevap
        echo $sum;
}

if(isset($_POST["islem"])){
  if(!empty($_POST["numbers"]))
      Addition($_POST["numbers"]);
  else
      echo "en az 2 sayi girmelisiniz !";
}

?>
