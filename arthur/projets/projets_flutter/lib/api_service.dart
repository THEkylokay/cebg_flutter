import 'dart:convert';
import 'package:http/http.dart' as http;

class ApiService {
  static const String baseUrl = 'http://localhost/Projet-main/includes/api/apicompte.php';

  // Méthode de connexion
  Future<Map<String, dynamic>> login(String email, String password) async {
    try {
      final response = await http.post(
        Uri.parse(baseUrl),
        headers: {'Content-Type': 'application/json'},
        body: json.encode({
          'action': 'login',
          'email': email,
          'password': password,
        }),
      );

      if (response.statusCode == 200) {
        final responseData = json.decode(response.body);
        return responseData;
      } else {
        throw Exception('Erreur HTTP: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Erreur de connexion: $e');
    }
  }

  // Méthode d'inscription
  Future<Map<String, dynamic>> registerUser({
    required String nomCavalier,
    required String prenomCavalier,
    required String dateNaissance,
    required String nomResponsable,
    required String rueResponsable,
    required String telResponsable,
    required String emailResponsable,
    required String password,
    required String numLicence,
    required String numAssurance,
    required String idCommune,
    required String idGalop,
  }) async {
    try {
      final response = await http.post(
        Uri.parse(baseUrl),
        headers: {'Content-Type': 'application/json'},
        body: json.encode({
          'action': 'register',
          'nomcavalier': nomCavalier,
          'prenomcavalier': prenomCavalier,
          'datenaissancecavalier': dateNaissance,
          'nomresponsable': nomResponsable,
          'rueresponsable': rueResponsable,
          'telresponsable': int.parse(telResponsable),
          'emailresponsable': emailResponsable,
          'password': password,
          'numlicence': int.parse(numLicence),
          'numassurance': int.parse(numAssurance),
          'idcommune': int.parse(idCommune),
          'idgalop': int.parse(idGalop),
        }),
      );

      if (response.statusCode == 200) {
        final responseData = json.decode(response.body);
        return responseData;
      } else {
        throw Exception('Erreur HTTP: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Erreur d\'inscription: $e');
    }
  }
}