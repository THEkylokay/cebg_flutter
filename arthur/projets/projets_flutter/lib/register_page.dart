import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'api_service.dart';
import 'login.dart';

class RegisterPage extends StatefulWidget {
  @override
  _RegisterPageState createState() => _RegisterPageState();
}

class _RegisterPageState extends State<RegisterPage> {
  final _formKey = GlobalKey<FormState>();
  final _apiService = ApiService();
  bool _isLoading = false;
  String _errorMessage = '';

  final _nomController = TextEditingController();
  final _prenomController = TextEditingController();
  final _dateNaissanceController = TextEditingController();
  final _nomResponsableController = TextEditingController();
  final _rueResponsableController = TextEditingController();
  final _telResponsableController = TextEditingController();
  final _emailResponsableController = TextEditingController();
  final _passwordController = TextEditingController();
  final _numLicenceController = TextEditingController();
  final _numAssuranceController = TextEditingController();
  final _idCommuneController = TextEditingController();
  final _idGalopController = TextEditingController();

  Future<void> _register() async {
    if (_formKey.currentState!.validate()) {
      setState(() {
        _isLoading = true;
        _errorMessage = '';
      });

      try {
        final response = await _apiService.registerUser(
          nomCavalier: _nomController.text,
          prenomCavalier: _prenomController.text,
          dateNaissance: _dateNaissanceController.text,
          nomResponsable: _nomResponsableController.text,
          rueResponsable: _rueResponsableController.text,
          telResponsable: _telResponsableController.text,
          emailResponsable: _emailResponsableController.text,
          password: _passwordController.text,
          numLicence: _numLicenceController.text,
          numAssurance: _numAssuranceController.text,
          idCommune: _idCommuneController.text,
          idGalop: _idGalopController.text,
        );

        if (response['success'] == true) {
          Navigator.pushReplacement(
            context,
            MaterialPageRoute(builder: (context) => LoginPage()),
          );
        } else {
          setState(() {
            _errorMessage = response['error'] ?? 'Erreur d\'inscription';
          });
        }
      } catch (e) {
        setState(() {
          _errorMessage = e.toString();
        });
      } finally {
        setState(() {
          _isLoading = false;
        });
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Inscription'),
      ),
      body: SingleChildScrollView(
        padding: EdgeInsets.all(16.0),
        child: Form(
          key: _formKey,
          child: Column(
            children: [
              TextFormField(
                controller: _nomController,
                decoration: InputDecoration(labelText: 'Nom du cavalier'),
                validator: (value) => value?.isEmpty ?? true ? 'Champ requis' : null,
              ),
              TextFormField(
                controller: _prenomController,
                decoration: InputDecoration(labelText: 'Prénom du cavalier'),
                validator: (value) => value?.isEmpty ?? true ? 'Champ requis' : null,
              ),
              TextFormField(
                controller: _dateNaissanceController,
                decoration: InputDecoration(labelText: 'Date de naissance (YYYY-MM-DD)'),
                validator: (value) => value?.isEmpty ?? true ? 'Champ requis' : null,
              ),
              TextFormField(
                controller: _nomResponsableController,
                decoration: InputDecoration(labelText: 'Nom du responsable'),
                validator: (value) => value?.isEmpty ?? true ? 'Champ requis' : null,
              ),
              TextFormField(
                controller: _rueResponsableController,
                decoration: InputDecoration(labelText: 'Rue du responsable'),
                validator: (value) => value?.isEmpty ?? true ? 'Champ requis' : null,
              ),
              TextFormField(
                controller: _telResponsableController,
                decoration: InputDecoration(labelText: 'Téléphone du responsable'),
                keyboardType: TextInputType.number,
                validator: (value) => value?.isEmpty ?? true ? 'Champ requis' : null,
              ),
              TextFormField(
                controller: _emailResponsableController,
                decoration: InputDecoration(labelText: 'Email du responsable'),
                validator: (value) => value?.isEmpty ?? true ? 'Champ requis' : null,
              ),
              TextFormField(
                controller: _passwordController,
                decoration: InputDecoration(labelText: 'Mot de passe'),
                obscureText: true,
                validator: (value) => value?.isEmpty ?? true ? 'Champ requis' : null,
              ),
              TextFormField(
                controller: _numLicenceController,
                decoration: InputDecoration(labelText: 'Numéro de licence'),
                keyboardType: TextInputType.number,
                validator: (value) => value?.isEmpty ?? true ? 'Champ requis' : null,
              ),
              TextFormField(
                controller: _numAssuranceController,
                decoration: InputDecoration(labelText: 'Numéro d\'assurance'),
                keyboardType: TextInputType.number,
                validator: (value) => value?.isEmpty ?? true ? 'Champ requis' : null,
              ),
              TextFormField(
                controller: _idCommuneController,
                decoration: InputDecoration(labelText: 'ID Commune'),
                keyboardType: TextInputType.number,
                validator: (value) => value?.isEmpty ?? true ? 'Champ requis' : null,
              ),
              TextFormField(
                controller: _idGalopController,
                decoration: InputDecoration(labelText: 'ID Galop'),
                keyboardType: TextInputType.number,
                validator: (value) => value?.isEmpty ?? true ? 'Champ requis' : null,
              ),
              SizedBox(height: 24.0),
              if (_errorMessage.isNotEmpty)
                Text(
                  _errorMessage,
                  style: TextStyle(color: Colors.red),
                ),
              SizedBox(height: 16.0),
              _isLoading
                  ? CircularProgressIndicator()
                  : ElevatedButton(
                      onPressed: _register,
                      child: Text('S\'inscrire'),
                    ),
            ],
          ),
        ),
      ),
    );
  }

  @override
  void dispose() {
    _nomController.dispose();
    _prenomController.dispose();
    _dateNaissanceController.dispose();
    _nomResponsableController.dispose();
    _rueResponsableController.dispose();
    _telResponsableController.dispose();
    _emailResponsableController.dispose();
    _passwordController.dispose();
    _numLicenceController.dispose();
    _numAssuranceController.dispose();
    _idCommuneController.dispose();
    _idGalopController.dispose();
    super.dispose();
  }
}