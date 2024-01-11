<div class="form-floating mb-3 mt-2">
  <input type="text" id="local_name" name="local_name" class="form-control" 
    value="{{old('local_name') ?? $platform->local_name ?? null }}" required/>
  <label class="form-label" for="local_name">
      {{trans('lti1p3::lti1p3.platform_local_name_label')}}
  </label>
</div>
<div class="form-floating mb-3">
  <input type="text" id="issuer_id" name="issuer_id" class="form-control" 
    value="{{old('issuer_id') ?? $platform->issuer_id ?? null }}"  required/>
  <label class="form-label" for="issuer_id">
      {{trans('lti1p3::lti1p3.platform_issuer_id_label')}}
  </label>
</div>
<div class="form-floating mb-3">
  <input type="text" id="client_id" name="client_id" class="form-control" 
    value="{{old('client_id') ?? $platform->client_id ?? null }}"  required/>
  <label class="form-label" for="client_id">
      {{trans('lti1p3::lti1p3.platform_client_id_label')}}
  </label>
</div>
<div class="form-floating mb-3">
  <input type="text" id="lti_advantage_token_url" name="lti_advantage_token_url"
    value="{{old('lti_advantage_token_url') ?? $platform->lti_advantage_token_url ?? null }}"  class="form-control" />
  <label class="form-label" for="lti_advantage_token_url">
      {{trans('lti1p3::lti1p3.platform_lti_advantage_token_url_label')}}
  </label>
</div>
<div class="form-floating mb-3">
  <input type="text" id="authorization_url" name="authorization_url"
    value="{{old('authorization_url') ?? $platform->authorization_url ?? null }}"  class="form-control" required />
  <label class="form-label" for="authorization_url">
      {{trans('lti1p3::lti1p3.platform_authorization_url_label')}}
  </label>
</div>
<div class="form-floating mb-3">
  <input type="text" id="authentication_url" name="authentication_url" 
    value="{{old('authentication_url') ?? $platform->authentication_url ?? null }}"  class="form-control" required />
  <label class="form-label" for="authentication_url">
      {{trans('lti1p3::lti1p3.platform_authentication_url_label')}}
  </label>
</div>
<div class="form-floating mb-3">
  <input type="text" id="json_webkey_url" name="json_webkey_url"
    value="{{old('json_webkey_url') ?? $platform->json_webkey_url ?? null }}"  class="form-control" required />
  <label class="form-label" for="json_webkey_url">
      {{trans('lti1p3::lti1p3.platform_json_webkey_url_label')}}
  </label>
</div>
<div class="form-floating mb-3">
  <input type="text" id="signature_method" name="signature_method"
    value="{{old('signature_method') ?? $platform->signature_method ?? 'RS256' }}"  value="RS256" class="form-control" required />
  <label class="form-label" for="signature_method">
      {{trans('lti1p3::lti1p3.platform_signature_method_label')}}
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" name="deployment_id_autoregister" type="checkbox" 
  @checked(old('deployment_id_autoregister') ?? $platform->deployment_id_autoregister ?? true)>
  <label class="form-check-label" for="flexCheckDefault">
    {{trans('lti1p3::lti1p3.platform_deployment_id_autoregister_label')}}
  </label>
</div>