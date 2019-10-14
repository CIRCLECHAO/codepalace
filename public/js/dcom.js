var domain = 'https://' + document.domain;

const login_dcom= '<div class="login_div">'+
    '                        <div class="login_row">\n' +
    '                            <label for="email" class="login_label col-sm-12 col-form-label text-md-left">邮箱</label>\n' +
    '\n' +
    '                            <div class="col-md-12">\n' +
    '                                <input id="email" type="email" class="form-control login_input" name="email" value="" required="" autofocus="">\n' +
    '\n' +
    '                                                            </div>\n' +
    '                        </div>\n' +
    '\n' +
    '                        <div class="login_row">\n' +
    '                            <label for="password" class="login_label col-md-12 col-form-label text-md-left">密码</label>\n' +
    '\n' +
    '                            <div class="col-md-12">\n' +
    '                                <input id="password" type="password" class="form-control login_input" name="password" required="">\n' +
    '\n' +
    '                                                            </div>\n' +
    '                        </div>\n' +
    '\n' +
    '                        <div class="login_row">\n' +
    '                            <div class="row third-row">\n' +
    '                                <div class="form-check pass_remember col-md-4">\n' +
    '                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">\n' +
    '\n' +
    '                                    <label class="form-check-label" for="remember">\n' +
    '                                        记住密码&nbsp;&nbsp;&nbsp;\n' +
    '                                    </label>\n' +
    '                                </div>\n' +
    '<div class="col-md-6 third-login">' +
    '第三方登录：' +
    '<a href="https://www.codepalace.xyz/qq"><img style="width: 30px;height: 27px;" src="'+domain+'/images/qq_login.png"></a>\n' +
    '</div>'+
    '                            </div>\n' +
    '                        </div>\n' +
    '\n' +
    '                        <div class="login_row">\n' +
    '                            <div class="col-md-12 ">\n' +
    '                                <button type="submit" class="btn btn-primary btn_login">\n' +
    '                                    登录\n' +
    '                                </button>\n' +
    '\n' +
    '                                <a class="btn btn-link btn_forget" href="javascript:void(0);">\n' +
    '                                    <span>忘记密码？</span>' +
    '                                </a>\n' +
    '                                <a class="btn btn-link login_register" onclick="open_register_dom();" href="javascript:void(0);">\n' +
    '                                    <span>注册账号</span>' +
    '                                </a>\n' +
    '                            </div>\n' +
    '                        </div>\n'+
    '</div>';



const register_dcom= '<div class="login_div">'+
    '                        <div class="login_row">\n' +
    '                            <label for="username" class="login_label col-md-12 col-form-label text-md-left">用户名</label>\n' +
    '\n' +
    '                            <div class="col-md-12">\n' +
    '                                <input id="username" class="form-control login_input" name="username" required="true">\n' +
    '\n' +
    '                                                            </div>\n' +
    '                        </div>\n' +

    '                        <div class="login_row">\n' +
    '                            <label for="email" class="login_label col-sm-12 col-form-label text-md-left">邮箱</label>\n' +
    '\n' +
    '                            <div class="col-md-12">\n' +
    '                                <input id="email" type="email" class="form-control login_input" name="email" value="" required="true" autofocus="">\n' +
    '\n' +
    '                                                            </div>\n' +
    '                        </div>\n' +
    '\n' +
    '                        <div class="login_row">\n' +
    '                            <label for="password" class="login_label col-md-12 col-form-label text-md-left">密码</label>\n' +
    '\n' +
    '                            <div class="col-md-12">\n' +
    '                                <input id="password" type="password" class="form-control login_input" name="password" required="true">\n' +
    '\n' +
    '                                                            </div>\n' +
    '                        </div>\n' +

    '                        <div class="login_row">\n' +
    '                            <label for="password-confirm" class="login_label col-md-12 col-form-label text-md-left">确认密码</label>\n' +
    '\n' +
    '                            <div class="col-md-12">\n' +
    '                                <input id="password-confirm" type="password" class="form-control login_input" name="password-confirm" required="true">\n' +
    '\n' +
    '                                                            </div>\n' +
    '                        </div>\n' +

    '\n' +
    '                        <div class="login_row">\n' +
    '                            <div class="row third-row-register">\n' +

    '<div class="col-md-6 third-login">' +
    '第三方登录：' +
    '<a href="https://www.codepalace.xyz/qq"><img style="width: 30px;height: 27px;" src="'+domain+'/images/qq_login.png"></a>\n' +
    '</div>'+
    '                            </div>\n' +
    '                        </div>\n' +
    '\n' +
    '                        <div class="login_row">\n' +
    '                            <div class="col-md-8 ">\n' +
    '                                <button type="submit" class="btn btn-primary btn_register">\n' +
    '                                    注册\n' +
    '                                </button>\n' +
    '\n' +
    '                            </div>\n' +
    '                        </div>\n'+
    '</div>';


const send_email_dcom= '<div class="login_div">'+
    '                        <div class="login_row">\n' +
    '                            <label for="email" class="login_label col-sm-12 col-form-label text-md-left">注册邮箱</label>\n' +
    '                            <div class="col-md-12">\n' +
    '                                <input id="forget_email" type="email" class="form-control login_input" name="email" value="" required="" autofocus="">\n' +
    '                            </div>\n' +
    '                        </div>\n' +
    '                        <div class="login_row">\n' +
    '                            <div class="col-md-8 ">\n' +
    '                                <button type="submit" class="btn btn-primary btn_sendemail">\n' +
    '                                    发送重置密码邮件\n' +
    '                                </button>\n' +
    '                            </div>\n' +
    '                        </div>\n'+
    '</div>';

const link_info_dcom = '<div class="link_info">' +
    '<img class="link_qq" src="'+domain+'/images/qq.jpg">' +
    '<img class="link_wx" src="'+domain+'/images/wx.jpg">' +
    '</div>';

const about_us_dcom = '<p class="about_info">' +
    '代码殿堂，是基于laravel框架开发的一个社交性的论坛，' +
    '是一个技术论坛，用于广大码农进行技术交流，以及最新的科技新闻的发布等等' +
    '</p>';

const version_dcom = '<p class="version_info">' +
    '本站代码是完全开源的，方便各位访问分析、研究' +
    '需要源码的请联系我，后续将会将完整源码上传到GITHUB' +
    '</p>';

const duty_dcom = '<div class="duty_info">' +
    '    <div class="">\n' +
    '        <div class="">\n' +
    '<span class=""><h3>总则</h3></span>\n' +
    '　　用户在接受代码殿堂服务之前，请务必仔细阅读本条款并同意本声明。<br>\n' +
    '　　用户直接或通过各类方式（如站外API引用等）间接使用代码殿堂服务和数据的行为，都将被视作已无条件接受本声明所涉全部内容；若用户对本声明的任何条款有异议，请停止使用代码殿堂所提供的全部服务。\n' +
    '<span class=""><h3>第一条</h3></span>\n' +
    '　　用户以各种方式使用代码殿堂服务和数据（包括但不限于发表、宣传介绍、转载、浏览及利用代码殿堂或代码殿堂用户发布内容）的过程中，不得以任何方式利用代码殿堂直接或间接从事违反中国法律、以及社会公德的行为，且用户应当恪守下述承诺：<br>\n' +
    '　　1. 发布、转载或提供的内容符合中国法律、社会公德<br>\n' +
    '　　2. 不得干扰、损害和侵犯代码殿堂的各种合法权利与利益；<br>\n' +
    '　　3. 遵守代码殿堂以及与之相关的网络服务的协议、指导原则、管理细则等；<br>\n' +
    '　　代码殿堂有权对违反上述承诺的内容予以删除。\n' +
    '<span class=""><h3>第二条</h3></span>\n' +
    '　　1. 代码殿堂仅为用户发布的内容提供存储空间，代码殿堂不对用户发表、转载的内容提供任何形式的保证：不保证内容满足您的要求，不保证代码殿堂的服务不会中断。因网络状况、通讯线路、第三方网站或管理部门的要求等任何原因而导致您不能正常使用代码殿堂，代码殿堂不承担任何法律责任。<br>\n' +
    '　　2. 用户在代码殿堂发表的内容（包含但不限于代码殿堂目前各产品功能里的内容）仅表明其个人的立场和观点，并不代表代码殿堂的立场或观点。作为内容的发表者，需自行对所发表内容负责，因所发表内容引发的一切纠纷，由该内容的发表者承担全部法律及连带责任。代码殿堂不承担任何法律及连带责任。<br>\n' +
    '　　3. 用户在代码殿堂发布侵犯他人知识产权或其他合法权益的内容，代码殿堂有权予以删除，并保留移交司法机关处理的权利。<br>\n' +
    '　　4. 个人或单位如认为代码殿堂上存在侵犯自身合法权益的内容，应准备好具有法律效应的证明材料，及时与代码殿堂取得联系，以便代码殿堂迅速做出处理。<br>\n' +
    '<span class="">联系我们:codepalace@qq.com </span>'+
    '</div>';


const log_dcom = '<div class="log_info">' +
    '<h5>2018-08-07</h5>'+
    '网站构想、购买服务器'+
    '<h5>2018-11-06</h5>'+
    '网站集成QQ登录'+
    '<h5>2018-11-07</h5>'+
    '域名备案通过'+
    '<h5>2018-11-21</h5>'+
    '修改了laravel自带的登录功能 实现弹框显示效果'+
    '<h5>2018-12-01</h5>'+
    '网站继承了新闻采集、实现了每日新闻自动采集'+
    '<h5>2018-12-04</h5>'+
    '网站实现了顶部模糊搜索'+
    '<h5>2019-01-09</h5>'+
    '网站实现了在线聊天'+
    '</div>';

const donate_info_dcom = '<div class="donate_info">' +
    '<img class="link_qq" src="'+domain+'/images/SKM.jpg">' +
    '</div>';

const friend_dcom ='<div class="friend_info">' +
    '<a target="_blank" href="https://www.google.com">谷歌一下</a>' +
    '<a target="_blank" href="https://www.baidu.com">百度一下</a>' +
    '<a target="_blank" href="https://www.cnblogs.com/Ychao/">我的博客园</a>' +
    '<a target="_blank" href="https://uyi2.com/albumMovieList?id=77&name=web%E5%89%8D%E7%AB%AF%E7%B2%BE%E5%93%81%E7%94%B5%E5%AD%90%E4%B9%A6%E5%85%A8%E9%9B%86">电子书城</a>' +

    '</div>';