package %package%.adapter;

import android.app.Activity;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.mobileia.helper.DateHelper;
import com.bumptech.glide.Glide;
import %package%.R;
import %package%.entity.%name%;

import java.util.List;

/**
 * Created by matiascamiletti on 18/9/16.
 */
public class %name%Adapter extends RecyclerView.Adapter<%name%Adapter.ViewHolder> {

    protected List<%name%> mValues = new ArrayList<%name%>();
    protected On%name%ListInteractionListener mListener;

    public %name%Adapter(){ }

    public %name%Adapter(On%name%ListInteractionListener listener){
        mListener = listener;
    }

    public %name%Adapter(List<%name%> items){
        setItems(items);
    }

    public %name%Adapter(List<%name%> items, On%name%ListInteractionListener listener){
        setItems(items);
        mListener = listener;
    }

    public void setItems(List<%name%> items){
        mValues = items;
        notifyDataSetChanged();
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_list_%name_lower%, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(final ViewHolder holder, int position) {
        // Seteamos el item
        holder.item = mValues.get(position);
        %on_bind_holder%
        
        // Seteamos el click en el elemento
        holder.view.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (null != mListener) {
                    mListener.onItemClick(holder.item);
                }
            }
        });
    }

    @Override
    public int getItemCount() {
        return mValues.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder {
        public final View view;
%properties%
        public %name% item;

        public ViewHolder(View view) {
            super(view);
            this.view = view;
%properties_init%
        }
    }

    public interface On%name%ListInteractionListener {
        void onItemClick(%name% item);
    }
}

