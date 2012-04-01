これは何？
モデルへのアクセスを簡単にするためのcakephp2.0向けPluginです。

例えば
今までCakephpでユーザー名からユーザーIDを求めたいと思った時、
コントローラに
$this->User->get_id_By_username('John');
と書いて、モデルにget_id_By_username($username)メソッドを実装しそこに
return $this->find('all',array('conditions'=>array...
といった文を書く必要がありました。

そのめんどくささをこのPluginを入れて3ステップの環境設定を行うと。
$this->User->get_id_By_username('John');
と書くだけでモデルに実装を書く必要がなくなり意図したものを取り出すことができます。

環境設定と使用方法
ステップ1.
設置方法は
|-app
  |-Plugin
    |-Dbaccess
というようになるようにする

ステップ2.
モデルに
class Example extends AppModel {
public $actsAs = array('Dbaccess.Simpleaccess');
というように書きます。

ステップ3.
コントローラから
$this->Model->get_カラム名_By_求めるためのカラム名(求めるためのカラム名の値);
や
モデルから
$this->get_カラム名_By_求めるためのカラム名(求めるためのカラム名の値);
というように使用してください。