package %package%;

import android.app.Activity;
import android.app.DatePickerDialog;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.DatePicker;
import android.widget.EditText;
import java.util.Calendar;

public class %name% extends AppCompatActivity {

    public static void createInstance(Activity context) {
        Intent intent = new Intent(context, %name%.class);
        context.startActivity(intent);
    }

%properties%

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_%xml%);
        // Inicializar la vista
        initViews();
    }

    public void onClickSend(final View v){

    }

    protected void initViews() {
%views%
    }
}