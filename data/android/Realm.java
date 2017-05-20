package %package%.entity;

import com.google.gson.JsonParser;

import java.util.Date;
import java.util.Map;
import com.google.gson.JsonObject;
import io.realm.RealmObject;
import io.realm.annotations.Index;
import io.realm.annotations.PrimaryKey;
import com.mobileia.helper.DateHelper;

/**
 * Created by matiascamiletti on 20/12/16.
 */

public class %name% extends RealmObject {

    %properties%
    public static %name% fromMap(Map<String, String> data){
        %name% entity = new %name%();
%from_map%
        return entity;
    }
    
    public static %name% fromJson(JsonObject json){
        %name% entity = new %name%();
%from_json%
        return entity;
    }
}