export function inPages(page, checkFromToPages){
    var result = false;
    for (var count = 0 ; count < checkFromToPages.length ; count++){
        try{
            var checkFromToPage = checkFromToPages[count];
            if (checkFromToPage["from"] != "" && checkFromToPage["to"] != ""){
                var from = parseInt(checkFromToPage["from"], 10);
                var to   = parseInt(checkFromToPage["to"], 10);
                if (from <= parseInt(page, 10) && parseInt(page, 10) <= to){
                    result = true;
                    break;
                }
            }
        } catch (e) {
        }
    }
    return result;
}

export function mb_convert_kana(text, option) {
    //PHPのmb_convert_kanaを再現。
    var katahan, kanazen, hirazen, mojilength, i, re;
    katahan = ["ｶﾞ", "ｷﾞ", "ｸﾞ", "ｹﾞ", "ｺﾞ", "ｻﾞ", "ｼﾞ", "ｽﾞ", "ｾﾞ", "ｿﾞ", "ﾀﾞ", "ﾁﾞ", "ﾂﾞ", "ﾃﾞ", "ﾄﾞ", "ﾊﾞ", "ﾊﾟ", "ﾋﾞ", "ﾋﾟ", "ﾌﾞ", "ﾌﾟ", "ﾍﾞ", "ﾍﾟ", "ﾎﾞ", "ﾎﾟ", "ｳﾞ", "ｰ", "ｧ", "ｱ", "ｨ", "ｲ", "ｩ", "ｳ", "ｪ", "ｴ", "ｫ", "ｵ", "ｶ", "ｷ", "ｸ", "ｹ", "ｺ", "ｻ", "ｼ", "ｽ", "ｾ", "ｿ", "ﾀ", "ﾁ", "ｯ", "ﾂ", "ﾃ", "ﾄ", "ﾅ", "ﾆ", "ﾇ", "ﾈ", "ﾉ", "ﾊ", "ﾋ", "ﾌ", "ﾍ", "ﾎ", "ﾏ", "ﾐ", "ﾑ", "ﾒ", "ﾓ", "ｬ", "ﾔ", "ｭ", "ﾕ", "ｮ", "ﾖ", "ﾗ", "ﾘ", "ﾙ", "ﾚ", "ﾛ", "ﾜ", "ｦ", "ﾝ", "ｶ", "ｹ", "ﾜ", "ｲ", "ｴ", "ﾞ", "ﾟ"];
    kanazen = ["ガ", "ギ", "グ", "ゲ", "ゴ", "ザ", "ジ", "ズ", "ゼ", "ゾ", "ダ", "ヂ", "ヅ", "デ", "ド", "バ", "パ", "ビ", "ピ", "ブ", "プ", "ベ", "ペ", "ボ", "ポ", "ヴ", "ー", "ァ", "ア", "ィ", "イ", "ゥ", "ウ", "ェ", "エ", "ォ", "オ", "カ", "キ", "ク", "ケ", "コ", "サ", "シ", "ス", "セ", "ソ", "タ", "チ", "ッ", "ツ", "テ", "ト", "ナ", "ニ", "ヌ", "ネ", "ノ", "ハ", "ヒ", "フ", "ヘ", "ホ", "マ", "ミ", "ム", "メ", "モ", "ャ", "ヤ", "ュ", "ユ", "ョ", "ヨ", "ラ", "リ", "ル", "レ", "ロ", "ワ", "ヲ", "ン", "ヵ", "ヶ", "ヮ", "ヰ", "ヱ", "゛", "゜"];
    hirazen = ["が", "ぎ", "ぐ", "げ", "ご", "ざ", "じ", "ず", "ぜ", "ぞ", "だ", "ぢ", "づ", "で", "ど", "ば", "ぱ", "び", "ぴ", "ぶ", "ぷ", "べ", "ぺ", "ぼ", "ぽ", "ヴ", "ー", "ぁ", "あ", "ぃ", "い", "ぅ", "う", "ぇ", "え", "ぉ", "お", "か", "き", "く", "け", "こ", "さ", "し", "す", "せ", "そ", "た", "ち", "っ", "つ", "て", "と", "な", "に", "ぬ", "ね", "の", "は", "ひ", "ふ", "へ", "ほ", "ま", "み", "む", "め", "も", "ゃ", "や", "ゅ", "ゆ", "ょ", "よ", "ら", "り", "る", "れ", "ろ", "わ", "を", "ん", "か", "け", "ゎ", "ゐ", "ゑ", "゛", "゜"];
    mojilength = katahan.length;
    //r:「全角」英字を「半角」に変換します。
    //a:「全角」英数字を「半角」に変換します。
    if(option.match(/[ra]/)) {
      text = text.replace(/[Ａ-ｚ]/g, function ($0) {
        return String.fromCharCode(parseInt($0.charCodeAt(0)) - 65248);
      });
    }
    //R:「半角」英字を「全角」に変換します。
    //A:「半角」英数字を「全角」に変換します
    if(option.match(/[RA]/)) {
      text = text.replace(/[A-z]/g, function ($0) {
        return String.fromCharCode(parseInt($0.charCodeAt(0)) + 65248);
      });
    }
    //n:「全角」数字を「半角」に変換します。
    //a:「全角」英数字を「半角」に変換します。
    if(option.match(/[na]/)) {
      text = text.replace(/[０-９]/g, function ($0) {
        return String.fromCharCode(parseInt($0.charCodeAt(0)) - 65248);
      });
    }
    //N:「半角」数字を「全角」に変換します。
    //A:「半角」英数字を「全角」に変換します
    if(option.match(/[NA]/)) {
      text = text.replace(/[0-9]/g, function ($0) {
        return String.fromCharCode(parseInt($0.charCodeAt(0)) + 65248);
      });
    }
    //s:「全角」スペースを「半角」に変換します。
    if(option.match(/s/)) {
      text = text.replace(/　/g, " ");
    }
    //S:「半角」スペースを「全角」に変換します。
    if(option.match(/S/)) {
      text = text.replace(/ /g, "　");
    }
    //k:「全角カタカナ」を「半角カタカナ」に変換します。
    if(option.match(/k/)) {
      for(i = 0; i < mojilength; i++) {
        re = new RegExp(kanazen[i], "g");
        text = text.replace(re, katahan[i]);
      }
    }
    //K:「半角カタカナ」を「全角カタカナ」に変換します。
    //V:濁点付きの文字を一文字に変換します。"K", "H" と共に使用します。
    if(option.match(/K/)) {
      if(!option.match(/V/)) {
        text = text.replace(/ﾞ/g, "゛");
        text = text.replace(/ﾟ/g, "゜");
      }
      for(i = 0; i < mojilength; i++) {
        re = new RegExp(katahan[i], "g");
        text = text.replace(re, kanazen[i]);
      }
    }
    //h:「全角ひらがな」を「半角カタカナ」に変換します。
    if(option.match(/h/)) {
      for(i = 0; i < mojilength; i++) {
        re = new RegExp(hirazen[i], "g");
        text = text.replace(re, katahan[i]);
      }
    }
    //H:「半角カタカナ」を「全角ひらがな」に変換します。
    //V:濁点付きの文字を一文字に変換します。"K", "H" と共に使用します。
    if(option.match(/H/)) {
      if(!option.match(/V/)) {
        text = text.replace(/ﾞ/g, "゛");
        text = text.replace(/ﾟ/g, "゜");
      }
      for(i = 0; i < mojilength; i++) {
        re = new RegExp(katahan[i], "g");
        text = text.replace(re, hirazen[i]);
      }
    }
    //c:「全角カタカナ」を「全角ひらがな」に変換します。
    if(option.match(/c/)) {
      for(i = 0; i < mojilength; i++) {
        re = new RegExp(kanazen[i], "g");
        text = text.replace(re, hirazen[i]);
      }
    }
    //C:「全角ひらがな」を「全角カタカナ」に変換します。
    if(option.match(/C/)) {
      for(i = 0; i < mojilength; i++) {
        re = new RegExp(hirazen[i], "g");
        text = text.replace(re, kanazen[i]);
      }
    }
    return text;
  }

export function htmlspecialchars(str){
  return (str + '').replace(/&/g,'&amp;')
                    .replace(/"/g,'&quot;')
                    .replace(/'/g,'&#039;')
                    .replace(/</g,'&lt;')
                    .replace(/>/g,'&gt;'); 
}

export function zenkana2Hankana(str) {
  var kanaMap = {
       "ガ": "ｶﾞ", "ギ": "ｷﾞ", "グ": "ｸﾞ", "ゲ": "ｹﾞ", "ゴ": "ｺﾞ",
       "ザ": "ｻﾞ", "ジ": "ｼﾞ", "ズ": "ｽﾞ", "ゼ": "ｾﾞ", "ゾ": "ｿﾞ",
       "ダ": "ﾀﾞ", "ヂ": "ﾁﾞ", "ヅ": "ﾂﾞ", "デ": "ﾃﾞ", "ド": "ﾄﾞ",
       "バ": "ﾊﾞ", "ビ": "ﾋﾞ", "ブ": "ﾌﾞ", "ベ": "ﾍﾞ", "ボ": "ﾎﾞ",
       "パ": "ﾊﾟ", "ピ": "ﾋﾟ", "プ": "ﾌﾟ", "ペ": "ﾍﾟ", "ポ": "ﾎﾟ",
       "ヴ": "ｳﾞ", "ヷ": "ﾜﾞ", "ヺ": "ｦﾞ",
       "ア": "ｱ", "イ": "ｲ", "ウ": "ｳ", "エ": "ｴ", "オ": "ｵ",
       "カ": "ｶ", "キ": "ｷ", "ク": "ｸ", "ケ": "ｹ", "コ": "ｺ",
       "サ": "ｻ", "シ": "ｼ", "ス": "ｽ", "セ": "ｾ", "ソ": "ｿ",
       "タ": "ﾀ", "チ": "ﾁ", "ツ": "ﾂ", "テ": "ﾃ", "ト": "ﾄ",
       "ナ": "ﾅ", "ニ": "ﾆ", "ヌ": "ﾇ", "ネ": "ﾈ", "ノ": "ﾉ",
       "ハ": "ﾊ", "ヒ": "ﾋ", "フ": "ﾌ", "ヘ": "ﾍ", "ホ": "ﾎ",
       "マ": "ﾏ", "ミ": "ﾐ", "ム": "ﾑ", "メ": "ﾒ", "モ": "ﾓ",
       "ヤ": "ﾔ", "ユ": "ﾕ", "ヨ": "ﾖ",
       "ラ": "ﾗ", "リ": "ﾘ", "ル": "ﾙ", "レ": "ﾚ", "ロ": "ﾛ",
       "ワ": "ﾜ", "ヲ": "ｦ", "ン": "ﾝ",
       "ァ": "ｧ", "ィ": "ｨ", "ゥ": "ｩ", "ェ": "ｪ", "ォ": "ｫ",
       "ッ": "ｯ", "ャ": "ｬ", "ュ": "ｭ", "ョ": "ｮ",
       "。": "｡", "、": "､", "ー": "ｰ", "「": "｢", "」": "｣", "・": "･",
       "A":"a","B":"b","C":"c","D":"d","E":"e","F":"f","G":"g","H":"h","I":"i","J":"j",
       "K":"k","L":"l","M":"m","N":"n","O":"o","P":"p","Q":"q","R":"r","S":"s","T":"t",
       "U":"u","V":"v","W":"w","X":"x","Y":"y","Z":"z",
       "Ａ":"a","Ｂ":"b","Ｃ":"c","Ｄ":"d","Ｅ":"e","Ｆ":"f","Ｇ":"g","Ｈ":"h","Ｉ":"i","Ｊ":"j",
       "Ｋ":"k","Ｌ":"l","Ｍ":"m","Ｎ":"n","Ｏ":"o","Ｐ":"p","Ｑ":"q","Ｒ":"r","Ｓ":"s","Ｔ":"t",
       "Ｕ":"u","Ｖ":"v","Ｗ":"w","Ｘ":"x","Ｙ":"y","Ｚ":"z",
       "ａ":"a","ｂ":"b","ｃ":"c","ｄ":"d","ｅ":"e","ｆ":"f","ｇ":"g","ｈ":"h","ｉ":"i","ｊ":"j",
       "ｋ":"k","ｌ":"l","ｍ":"m","ｎ":"n","ｏ":"o","ｐ":"p","ｑ":"q","ｒ":"r","ｓ":"s","ｔ":"t",
       "ｕ":"u","ｖ":"v","ｗ":"w","ｘ":"x","ｙ":"y","ｚ":"z",
  }
  var reg = new RegExp('(' + Object.keys(kanaMap).join('|') + ')', 'g');
  return str
          .replace(reg, function (match) {
              return kanaMap[match];
          })
          .replace(/゛/g, 'ﾞ')
          .replace(/゜/g, 'ﾟ');
};

export function isPage(val){
  if (val == null){ return false; }
  if (val == ""){ return false; }
  var pattern = /^([1-9]\d*|0)$/;
  return pattern.test(val);
}
