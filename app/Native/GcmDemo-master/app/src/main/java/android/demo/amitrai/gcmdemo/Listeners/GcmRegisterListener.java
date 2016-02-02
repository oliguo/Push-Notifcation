package android.demo.amitrai.gcmdemo.Listeners;

/**
 * Created by amitrai on 27/1/16.
 */
public interface GcmRegisterListener {

    public void OnRegisterSuccess(String TOKEN);
    public void onRegisterFailure(String ERROR_MESSAGE);
}
