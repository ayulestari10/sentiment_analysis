<?php  

class Preprocessing{

    /**
     *    Method ini digunakan untuk praproses casefolding.
     *    @author Ayu Lestari
     *    @param data -> pendapat dalam kalimat atau paragraf
     *    @return data
    */
    public function casefolding($data){

        if(is_array($data)){
            
            $implode = implode(" ", $data);
            return strtolower($implode); 
        }
        else {
            return strtolower($data);    
        }
    }


    /**
     *    Method ini digunakan untuk praproses data memisah paragraf menjadi kalimat.
     *    @author Ayu Lestari
     *    @param data -> pendapat
     *    @return array kalimat
    */

    public function sentence_splitter($data){
        $hasil = explode('.', $data);

        return $hasil;
    }


    /**
     *    Method ini digunakan untuk praproses stemming.
     *    @author Ayu Lestari
     *    @param kalimat
     *    @return string
    */

    public function stem($sentence)
    {
        $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        $stemmer  = $stemmerFactory->createStemmer();

        return $stemmer->stem($sentence);
    }

    /**
     *    Method ini digunakan untuk praproses tokenizing.
     *
     *    @author Ayu Lestari
     *    @param data -> pendapat yang sudah dilakukan sentence splitter
     *    @param delimiter/pemisah
     *    @return assosiative array
    */

    public function tokenizing($data, $delimiter){
        $jmlh_kalimat = count($data);
        $hasil = [];

        if($jmlh_kalimat >= 1){

            for ($i = 0; $i<count($data); $i++) {

                $hasil[$i] = explode($delimiter, $data[$i]); 
            }
        }
        
        return $hasil;
    }

    public function tokenizing2($data, $delimiter)
    {
        return explode($delimiter, $data);
    }

    /**
     *  Method ini digunakan untuk praproses stopword_removal.
     *
     *  @author Ayu Lestari
     *  @param data -> token2
     *  @return array of object
    */

    public function stopwords_removal($data){
        $kamus = [];
        $hasil = [];

        $kamus = $this->read_file_by_line("kamus_stopwords_removal");

        foreach($data as $kata){
            $kata = array_diff($kata, [""]);
            $hasil[] = array_diff($kata, $kamus);
        }            

        return $hasil;
    }

    public function stopwords_removal2($data)
    {
        $kamus = $this->read_file_by_line("kamus_stopwords_removal");
        return array_diff($data, $kamus);
    }

    /**
     *    Method ini digunakan untuk membaca file.
     *    @author Ayu Lestari
     *    @param nama file
     *    @return konten dalam file
    */

    public function read_file($filename){
        $myfile = "assets/doc/$filename.txt";
        $handle = fopen($myfile, "r") or die("Unable to open file!");
        $contents = fread($handle, filesize($myfile));
        fclose($handle);

        return $contents;
    }

    /**
     *    Method ini digunakan untuk membaca konten file perbaris.
     *    @author Ayu Lestari
     *    @param nama file
     *    @return array setiap baris konten dokumen
    */

    public function read_file_by_line($filename){
        $hasil = [];

        $handle = @fopen("assets/doc/$filename.txt", "r");
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                $hasil[] = preg_replace( "/\r|\n/", "", $buffer);
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
            }
            fclose($handle);
        }

        return $hasil;
    }
	
}

?>