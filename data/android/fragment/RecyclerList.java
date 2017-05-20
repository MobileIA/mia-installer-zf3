package %package%.fragment;

import android.content.Context;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import %package%.R;
import %package%.entity.%name%;
import %package%.adapter.%name%Adapter;

public class %name%Fragment extends Fragment implements %name%Adapter.On%name%ListInteractionListener {

    protected %name%Adapter mAdapter;
    protected RecyclerView mRecyclerView;

    public %name%Fragment() {
    }

    public static %name%Fragment newInstance() {
        %name%Fragment fragment = new %name%Fragment();
        return fragment;
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_%name_lower%_list, container, false);

        // Set the adapter
        mAdapter = new %name%Adapter(this);
        // Get Context
        Context context = view.getContext();
        // Find RecyclerView
        mRecyclerView = (RecyclerView) view.findViewById(R.id.list);
        mRecyclerView.setLayoutManager(new LinearLayoutManager(context));
        mRecyclerView.setAdapter(mAdapter);

        return view;
    }

    @Override
    public void onItemClick(%name% item) {

    }
}
