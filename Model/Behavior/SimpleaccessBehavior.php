<?php
/**
 * DBへのアクセスを簡単にするためのBehaviorです
 * cakephp2.0向けです。
 *
 * @author takahirom
 */
class SimpleaccessBehavior extends ModelBehavior {
    public $mapMethods = array('/(\w+)_(\w+)_(\w+)_(\w+)/'=>'call');
    /**
     * モデルからfindする
     * @param object $model 処理するモデル
     * @param object $methodarray methodとして呼んだ文字列を_でスプリットした結果
     * @param object $args 引数
     * @return rows
     */
    private function get($model, $methodarray, $args) {
        return $model->find('all', array('conditions'=>array($methodarray[3]=>$args[0]), 'fields'=>array($methodarray[1])));
    }
    /**
     *
     * @see get
     */
    private function getAll($model, $methodarray, $args) {
        return get($model, $methodarray, $args);
    }

    /**
     * モデルからfind firstする
     * @param object $model 処理するモデル
     * @param object $methodarray methodとして呼んだ文字列を_でスプリットした結果
     * @param object $args 引数
     * @return row
     */
    private function getFirst($model, $methodarray, $args) {
        return $model->find('first', array('conditions'=>array($methodarray[3]=>$args[0]), 'fields'=>array($methodarray[1])));
    }

    /**
     * モデルの条件に合うものをアップデートする
     * @param object $model 処理するモデル
     * @param object $methodarray methodとして呼んだ文字列を_でスプリットした結果
     * @param object $args 引数
     * @return
     */
    private function set($model, $methodarray, $args) {
        return $model->updateAll(array($methodarray[1]=>$args[1]), array($methodarray[3]=>$args[0]));
    }
    /**
     * 例えば$this->model->get_test1_By_test2(1234)で呼んだとすると
     * このcallが呼ばれ、callの引数にその情報が格納される。
     *
     * @param object $model 呼ばれたモデル
     * @param object $method メソッドを呼んだも文字列、例でいうとget_test1_By_test2
     * @param object $args1 引数
     * @param object $args2 [optional]
     * @return
     */
    public function call($model, $method, $args1, $args2 = null) {
        $methodarray = split("_", $method);
        if (count($methodarray) != 4 or !method_exists($this, $methodarray[0])) {
            print "Usage: $this->Model->Get_selectcolumn_By_fromcolumn(value,tablename)<br>";
            die("Example: $this->User->Get_id_By_name('John')");
        }

        if ($methodarray[1] == "all")
            $methodarray[1] = '*';

        if ($args2 == null) {
            $this->rows = $this-> {$methodarray[0]} ($model, $methodarray, array($args1));
        } else {
            $this->rows = $this-> {$methodarray[0]} ($model, $methodarray, array($args1, $args2));
        }
        return $this->rows;
    }

}
