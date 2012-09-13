package pl.cms.system.client.model.presenter;

import java.util.ArrayList;

import pl.cms.helpers.client.json.DataEntry;
import pl.cms.helpers.client.var.Value;

public class PresenterImpl implements Presenter,Presenter.View {
	private ArrayList<Value> dataRequests = new ArrayList<Value>();
	private Activity listener;
	
	@Override
	public void getData(String name, Object view){
		Value v = new Value(name, view);
		dataRequests.add(v);
		listener.getData(name);
	}
	
	@Override
	public void setData(DataEntry data){
		View v = getView(data.getName());
		if(v!=null){
			v.setData(data);
		}
	}
	
	private View getView(String name){
		for (int i = 0; i < dataRequests.size(); i++) {
			if(dataRequests.get(i).getName().equals(name)){
				return (View)dataRequests.get(i);
			}
		}
		return null;
	}

	public Activity getListener() {
		return listener;
	}

	@Override
	public void setListener(Activity listener) {
		this.listener = listener;
	}
}
