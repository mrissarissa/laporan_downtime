<?php namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SPVModel;
use App\Models\StaffAdminModel;

class LoginController extends BaseController {

    public function index()
    {
        return view('login');
    }

    public function registrasi_view()
    {
        return view('register');
    }

    public function saveRegister()
    {
        if (!$this->validate([
            'nik' => [
                'rules' => 'required|min_length[4]|is_unique[users.nik]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'min_length' => '{field} Minimal 4 Karakter',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'name' => [
                'rules' => 'required|min_length[4]|max_length[20]',
                'errors' => [
                    'required' => '{field} Harus diisi',
                    'min_length' => '{field} Minimal 4 Karakter',
                    'max_length' => '{field} Maksimal 20 Karakter',
                ]
            ],
            'line' => [
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
           
        ])) 
        {
          
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
  
        $users = new UserModel();
        $users->insert([
            'nik' => $this->request->getVar('nik'),
            'line' => $this->request->getVar('line'),
            'role' => 1,
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'name' => $this->request->getVar('name')
        ]);
        return redirect()->to('/login');
    }

    public function islogin()
    {
        if (!$this->validate([
            'nik' => [
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
            'password' => [
                'errors' => [
                    'required' => '{field} Harus diisi',
                ]
            ],
           
        ])) 
        {
            //menampilkan apabila terdapat eror
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
  
        //cek data 
        $users = new UserModel();
        $dataUser = $users->where([
            'nik'       => $this->request->getVar('nik'),
            'role'      => 1
        ])->first();

        $spv = new SPVModel();
        $dataSpv = $spv->where([
            'nik'       => $this->request->getVar('nik'),
        ])->first();
        

        $staff = new StaffAdminModel();
        $dataStaff = $staff->where([
            'nik'       => $this->request->getVar('nik'),
        ])->first();

        
       
 
        if($dataUser)
        {
            //cek password sesuai 
            $password = $this->request->getVar('password');
            if(password_verify($password, $dataUser->password)){
                session()->set([
                    'nik' => $dataUser->nik,
                    'name' => $dataUser->name,
                    'role'  => $dataUser->role,
                    'line'  => $dataUser->line,
                    'logged_in' => TRUE
                ]);

                return redirect()->to(base_url('gl/dashboard'));
            }else{
                session()->setFlashdata('error', 'Nik & Password Salah user');
                // return atau kembalian ke login v
                return redirect()->back();
            }
         
        }else if($dataSpv){
            $password = $this->request->getVar('password');
            if(password_verify($password, $dataSpv->password)){
                //input data ke session
                session()->set([
                    'nik' => $dataSpv->nik,
                    'name' => $dataSpv->name,
                    'role'  => $dataSpv->role,
                    'logged_in' => TRUE
                ]);

                return redirect()->to(base_url('spv/dashboard'));
            }else{
                session()->setFlashdata('error', 'Nik & Password Salah');
                return redirect()->back();
            }
         
        }else if($dataStaff)
        {
            $password = $this->request->getVar('password');
            if(password_verify($password, $dataStaff->password)){
                session()->set([
                    'nik' => $dataStaff->nik,
                    'name' => $dataStaff->name,
                    'role'  => $dataStaff->role,
                    'logged_in' => TRUE
                ]);

                return redirect()->to(base_url('staff/dashboard'));
            }else{
                session()->setFlashdata('error', 'Nik & Password Salah');
                return redirect()->back();
            }
         
        }
        else{
            $admin = new UserModel();
            $dataAdmin = $users->where([
                'nik'       => $this->request->getVar('nik'),
                'role'      => 4
            ])->first();
            if($dataAdmin)
            {
                $password = $this->request->getVar('password');
                if(password_verify($password, $dataAdmin->password)){
                    session()->set([
                        'nik' => $dataAdmin->nik,
                        'name' => $dataAdmin->name,
                        'role'  => $dataAdmin->role,
                        'logged_in' => TRUE
                    ]);

                    return redirect()->to(base_url('adminict/dashboard'));
                }else{
                    session()->setFlashdata('error', 'Nik & Password Salah');
                    return redirect()->back();
                }
         

            }else{
                session()->setFlashdata('error', 'Nik & Password Salah all');
                return redirect()->back();
            }
           
        }
        return redirect()->to('/login');

    }

    function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}

/* End of file Controllername.php */
